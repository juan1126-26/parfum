<?php

namespace Tests\Feature;

use App\Models\Climate;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\Season;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminClimateSeasonOccasionTest extends TestCase
{
    use RefreshDatabase;

    public function test_taxonomy_listings_require_administration_preserve_search_pagination_and_show_perfume_counts(): void
    {
        $this->get(route('admin.climates.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.seasons.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.occasions.index'))->assertRedirect(route('admin.login'));

        $climate = Climate::factory()->create(['name' => 'Contexto de prueba', 'sort_order' => 0]);
        $season = Season::factory()->create(['name' => 'Ciclo de prueba', 'sort_order' => 0]);
        $occasion = Occasion::factory()->create(['name' => 'Momento de prueba', 'sort_order' => 0]);
        Climate::factory()->count(12)->create(['name' => 'Contexto de prueba']);
        Season::factory()->count(12)->create(['name' => 'Ciclo de prueba']);
        Occasion::factory()->count(12)->create(['name' => 'Momento de prueba']);
        $perfume = Perfume::factory()->create();
        $perfume->climates()->attach($climate);
        $perfume->seasons()->attach($season);
        $perfume->occasions()->attach($occasion);

        $this->actingAs($this->administrator())
            ->get(route('admin.climates.index', ['q' => 'Contexto']))
            ->assertOk()
            ->assertViewHas('climates', fn ($climates): bool => $climates->total() === 13
                && $climates->perPage() === 12
                && $climates->firstWhere('id', $climate->id)?->perfumes_count === 1
                && str_contains($climates->nextPageUrl(), 'q=Contexto'));

        $this->actingAs($this->administrator())
            ->get(route('admin.seasons.index', ['q' => 'Ciclo']))
            ->assertOk()
            ->assertViewHas('seasons', fn ($seasons): bool => $seasons->total() === 13
                && $seasons->firstWhere('id', $season->id)?->perfumes_count === 1
                && str_contains($seasons->nextPageUrl(), 'q=Ciclo'));

        $this->actingAs($this->administrator())
            ->get(route('admin.occasions.index', ['q' => 'Momento']))
            ->assertOk()
            ->assertViewHas('occasions', fn ($occasions): bool => $occasions->total() === 13
                && $occasions->firstWhere('id', $occasion->id)?->perfumes_count === 1
                && str_contains($occasions->nextPageUrl(), 'q=Momento'));
    }

    public function test_administrator_can_create_validate_edit_and_toggle_a_climate_without_deleting_it(): void
    {
        $payload = $this->payload('Templado', 'templado', 3);

        $this->actingAs($this->administrator())
            ->post(route('admin.climates.store'), $payload)
            ->assertRedirect(route('admin.climates.index'))
            ->assertSessionHas('success');

        $climate = Climate::query()->where('slug', 'templado')->firstOrFail();

        $this->assertInvalidClimatePayload(route('admin.climates.create'), route('admin.climates.store'));

        $this->actingAs($this->administrator())
            ->put(route('admin.climates.update', $climate), $this->payload('Templado Renovado', 'templado-renovado', 4))
            ->assertRedirect(route('admin.climates.edit', 'templado-renovado'));

        $climate->refresh();

        $this->assertToggledWithoutDeletion('climates', $climate, 'admin.climates.toggle');
    }

    public function test_administrator_can_create_validate_edit_and_toggle_a_season_without_deleting_it(): void
    {
        $payload = $this->payload('Primavera', 'primavera', 3);

        $this->actingAs($this->administrator())
            ->post(route('admin.seasons.store'), $payload)
            ->assertRedirect(route('admin.seasons.index'))
            ->assertSessionHas('success');

        $season = Season::query()->where('slug', 'primavera')->firstOrFail();

        $this->assertInvalidClimatePayload(route('admin.seasons.create'), route('admin.seasons.store'));

        $this->actingAs($this->administrator())
            ->put(route('admin.seasons.update', $season), $this->payload('Primavera Renovada', 'primavera-renovada', 4))
            ->assertRedirect(route('admin.seasons.edit', 'primavera-renovada'));

        $season->refresh();

        $this->assertToggledWithoutDeletion('seasons', $season, 'admin.seasons.toggle');
    }

    public function test_administrator_can_create_validate_edit_and_toggle_an_occasion_without_deleting_it(): void
    {
        $payload = $this->payload('Cena Formal', 'cena-formal', 3);

        $this->actingAs($this->administrator())
            ->post(route('admin.occasions.store'), $payload)
            ->assertRedirect(route('admin.occasions.index'))
            ->assertSessionHas('success');

        $occasion = Occasion::query()->where('slug', 'cena-formal')->firstOrFail();

        $this->assertInvalidClimatePayload(route('admin.occasions.create'), route('admin.occasions.store'));

        $this->actingAs($this->administrator())
            ->put(route('admin.occasions.update', $occasion), $this->payload('Cena Intima', 'cena-intima', 4))
            ->assertRedirect(route('admin.occasions.edit', 'cena-intima'));

        $occasion->refresh();

        $this->assertToggledWithoutDeletion('occasions', $occasion, 'admin.occasions.toggle');
    }

    private function payload(string $name, string $slug, int $sortOrder): array
    {
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => 'Una descripcion editorial para el catalogo.',
            'sort_order' => $sortOrder,
        ];
    }

    private function assertInvalidClimatePayload(string $formRoute, string $storeRoute): void
    {
        $this->actingAs($this->administrator())
            ->from($formRoute)
            ->post($storeRoute, ['name' => '', 'slug' => 'slug invalido', 'sort_order' => -1])
            ->assertRedirect($formRoute)
            ->assertSessionHasErrors(['name', 'slug', 'sort_order'])
            ->assertSessionHasInput('slug', 'slug invalido');
    }

    private function assertToggledWithoutDeletion(string $table, object $taxonomy, string $routeName): void
    {
        $this->actingAs($this->administrator())
            ->patch(route($routeName, $taxonomy))
            ->assertRedirect();

        $this->assertDatabaseHas($table, ['id' => $taxonomy->id, 'is_active' => false]);
        $this->assertDatabaseCount($table, 1);
    }

    private function administrator(): User
    {
        return User::factory()->create();
    }
}
