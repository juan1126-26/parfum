<?php

namespace Tests\Feature;

use App\Enums\OlfactoryStage;
use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Climate;
use App\Models\Note;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\Season;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPerfumeTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_search_sort_and_paginate_perfumes(): void
    {
        $brand = Brand::factory()->create(['name' => 'Casa Busqueda']);
        $category = Category::factory()->create();

        Perfume::factory()->count(13)->create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
        ]);
        $inactive = Perfume::factory()->create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->administrator())
            ->get(route('admin.perfumes.index', [
                'q' => 'Busqueda',
                'sort' => 'name',
                'direction' => 'asc',
            ]));

        $response->assertOk()
            ->assertSee($brand->name)
            ->assertViewHas('perfumes', function ($perfumes): bool {
                return $perfumes->perPage() === 12
                    && $perfumes->total() === 14
                    && $perfumes->first()->relationLoaded('brand')
                    && $perfumes->first()->relationLoaded('category')
                    && str_contains($perfumes->nextPageUrl(), 'q=Busqueda');
            });

        $this->actingAs($this->administrator())
            ->get(route('admin.perfumes.index', ['status' => 'inactive']))
            ->assertOk()
            ->assertSee($inactive->name)
            ->assertViewHas('perfumes', fn ($perfumes): bool => $perfumes->total() === 1);
    }

    public function test_administrator_can_create_a_perfume_with_real_relations(): void
    {
        [$data, $relations] = $this->perfumePayload();

        $response = $this->actingAs($this->administrator())
            ->post(route('admin.perfumes.store'), $data);

        $perfume = Perfume::query()->where('slug', $data['slug'])->firstOrFail();

        $response->assertRedirect(route('admin.perfumes.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('perfumes', [
            'id' => $perfume->id,
            'brand_id' => $relations['brand']->id,
            'category_id' => $relations['category']->id,
            'name' => $data['name'],
            'is_featured' => true,
            'is_best_seller' => false,
        ]);

        $perfume->load('accords', 'notes', 'climates', 'seasons', 'occasions');

        $this->assertSame($relations['accord']->id, $perfume->accords->first()->id);
        $this->assertSame(86, $perfume->accords->first()->pivot->intensity);
        $this->assertTrue($perfume->accords->first()->pivot->is_primary);
        $this->assertSame(OlfactoryStage::Heart, $perfume->notes->first()->pivot->stage);
        $this->assertTrue($perfume->climates->contains($relations['climate']));
        $this->assertTrue($perfume->seasons->contains($relations['season']));
        $this->assertTrue($perfume->occasions->contains($relations['occasion']));
    }

    public function test_invalid_perfume_creation_preserves_input_and_creates_no_record(): void
    {
        [$data] = $this->perfumePayload();
        $data['name'] = '';
        $data['slug'] = 'slug invalido';
        $data['brand_id'] = 999999;

        $this->actingAs($this->administrator())
            ->from(route('admin.perfumes.create'))
            ->post(route('admin.perfumes.store'), $data)
            ->assertRedirect(route('admin.perfumes.create'))
            ->assertSessionHasErrors(['name', 'slug', 'brand_id'])
            ->assertSessionHasInput('slug', 'slug invalido');

        $this->assertDatabaseCount('perfumes', 0);
    }

    public function test_administrator_can_edit_a_perfume_and_resynchronize_relations(): void
    {
        [$initialData, $initialRelations] = $this->perfumePayload();
        $perfume = Perfume::factory()->create([
            'brand_id' => $initialRelations['brand']->id,
            'category_id' => $initialRelations['category']->id,
            'slug' => 'aroma-original',
        ]);
        $perfume->accords()->attach($initialRelations['accord'], ['intensity' => 60, 'sort_order' => 1, 'is_primary' => true]);
        $perfume->notes()->attach($initialRelations['note'], ['stage' => OlfactoryStage::Top->value, 'sort_order' => 1]);

        [$data, $relations] = $this->perfumePayload('aroma-renovado');
        $data['name'] = 'Aroma Renovado';

        $this->actingAs($this->administrator())
            ->put(route('admin.perfumes.update', $perfume), $data)
            ->assertRedirect(route('admin.perfumes.edit', 'aroma-renovado'));

        $perfume->refresh()->load('accords', 'notes', 'climates', 'seasons', 'occasions');

        $this->assertSame('Aroma Renovado', $perfume->name);
        $this->assertSame('aroma-renovado', $perfume->slug);
        $this->assertSame([$relations['accord']->id], $perfume->accords->modelKeys());
        $this->assertSame([$relations['note']->id], $perfume->notes->modelKeys());
        $this->assertSame([$relations['climate']->id], $perfume->climates->modelKeys());
        $this->assertSame([$relations['season']->id], $perfume->seasons->modelKeys());
        $this->assertSame([$relations['occasion']->id], $perfume->occasions->modelKeys());
    }

    public function test_administrator_can_toggle_a_perfume_without_deleting_it_and_admin_pages_are_not_cacheable(): void
    {
        $perfume = Perfume::factory()->create(['is_active' => true]);

        $this->actingAs($this->administrator())
            ->patch(route('admin.perfumes.toggle', $perfume))
            ->assertRedirect();

        $this->assertDatabaseHas('perfumes', ['id' => $perfume->id, 'is_active' => false]);
        $this->assertDatabaseCount('perfumes', 1);

        $response = $this->actingAs($this->administrator())
            ->get(route('admin.perfumes.index'))
            ->assertOk()
            ->assertHeader('Pragma', 'no-cache')
            ->assertHeader('Expires', '0');

        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', $response->headers->get('Cache-Control'));
    }

    /** @return array{0: array<string, mixed>, 1: array<string, object>} */
    private function perfumePayload(string $slug = 'aroma-de-prueba'): array
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $accord = Accord::factory()->create();
        $note = Note::factory()->create();
        $climate = Climate::factory()->create();
        $season = Season::factory()->create();
        $occasion = Occasion::factory()->create();

        return [[
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Aroma de Prueba',
            'slug' => $slug,
            'short_description' => 'Una descripcion breve.',
            'description' => 'Una descripcion completa para la fragancia.',
            'editorial_story' => 'Una historia editorial.',
            'longevity_level' => 'intense',
            'projection_level' => 'moderate',
            'intensity_level' => 'soft',
            'is_featured' => '1',
            'is_best_seller' => '0',
            'sort_order' => 4,
            'accords' => [
                $accord->id => ['selected' => '1', 'intensity' => 86, 'sort_order' => 1],
            ],
            'primary_accord_id' => $accord->id,
            'notes' => [
                $note->id => ['selected' => '1', 'stage' => 'heart', 'sort_order' => 2],
            ],
            'climate_ids' => [$climate->id],
            'season_ids' => [$season->id],
            'occasion_ids' => [$occasion->id],
        ], compact('brand', 'category', 'accord', 'note', 'climate', 'season', 'occasion')];
    }

    private function administrator(): User
    {
        return User::factory()->create();
    }
}
