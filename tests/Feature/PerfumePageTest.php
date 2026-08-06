<?php

namespace Tests\Feature;

use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerfumePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_active_perfume_is_available_by_slug_and_catalog_links_to_it(): void
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $perfume = Perfume::factory()->for($brand)->for($category)->create(['slug' => 'velo-editorial']);
        $perfume->accords()->attach(Accord::factory()->create(), ['intensity' => 80, 'sort_order' => 1, 'is_primary' => true]);

        $this->get(route('catalog.show', $perfume))
            ->assertOk()
            ->assertSee($perfume->name)
            ->assertSee(route('catalog'), false)
            ->assertSee('<link rel="canonical" href="'.route('catalog.show', $perfume).'">', false);

        $this->get(route('catalog'))
            ->assertOk()
            ->assertSee(route('catalog.show', $perfume), false)
            ->assertDontSee('/catalogo/'.$perfume->id, false);
    }

    public function test_inactive_and_unknown_perfumes_return_not_found(): void
    {
        $perfume = Perfume::factory()->create(['slug' => 'fragancia-oculta', 'is_active' => false]);

        $this->get(route('catalog.show', $perfume))->assertNotFound();
        $this->get('/catalogo/no-existe')->assertNotFound();
    }

    public function test_related_perfumes_are_active_and_never_include_the_current_perfume(): void
    {
        $category = Category::factory()->create();
        $current = Perfume::factory()->for($category)->create(['slug' => 'actual']);
        $visible = Perfume::factory()->for($category)->create(['slug' => 'visible']);
        $hidden = Perfume::factory()->for($category)->create(['slug' => 'oculto', 'is_active' => false]);

        $this->get(route('catalog.show', $current))
            ->assertOk()
            ->assertSee($visible->name)
            ->assertDontSee($hidden->name)
            ->assertViewHas('relatedPerfumes', fn ($perfumes) => ! $perfumes->contains('id', $current->id));
    }

    public function test_a_perfume_with_incomplete_optional_data_still_renders(): void
    {
        $perfume = Perfume::factory()->create([
            'editorial_story' => null,
            'description' => null,
            'short_description' => null,
            'longevity_level' => null,
            'projection_level' => null,
            'intensity_level' => null,
        ]);

        $this->get(route('catalog.show', $perfume))->assertOk()->assertSee($perfume->name);
    }
}
