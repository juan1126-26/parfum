<?php

namespace Tests\Feature;

use App\Http\Controllers\Public\CatalogController;
use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CatalogDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_filters_public_perfumes_and_eager_loads_card_data(): void
    {
        $brand = Brand::factory()->create(['name' => 'Casa Serena', 'slug' => 'casa-serena']);
        $category = Category::factory()->create(['name' => 'Perfumería Nicho', 'slug' => 'perfumeria-nicho']);
        $perfume = Perfume::factory()->for($brand)->for($category)->create([
            'name' => 'Bruma Serena',
            'is_featured' => true,
        ]);
        $inactivePerfume = Perfume::factory()->for($brand)->for($category)->create([
            'name' => 'Bruma Oculta',
            'is_active' => false,
        ]);
        $accords = Accord::factory()->count(4)->create();

        foreach ($accords as $position => $accord) {
            $perfume->accords()->attach($accord, [
                'intensity' => 80 - $position,
                'sort_order' => $position + 1,
                'is_primary' => $position === 0,
            ]);
        }

        $data = app(CatalogController::class)(Request::create('/catalogo', 'GET', [
            'q' => '  Serena  ',
            'category' => $category->slug,
            'brand' => $brand->slug,
        ]))->getData();

        $this->assertSame([$perfume->id], $data['perfumes']->pluck('id')->all());
        $this->assertNotContains($inactivePerfume->id, $data['perfumes']->pluck('id')->all());
        $this->assertTrue($data['perfumes']->first()->relationLoaded('brand'));
        $this->assertTrue($data['perfumes']->first()->relationLoaded('category'));
        $this->assertCount(3, $data['perfumes']->first()->accords);
        $this->assertSame('Serena', $data['search']);
    }

    public function test_catalog_ignores_invalid_filters_and_preserves_search_during_pagination(): void
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        foreach (range(1, 7) as $position) {
            Perfume::factory()->for($brand)->for($category)->create([
                'name' => "Aroma {$position}",
                'slug' => "aroma-{$position}",
            ]);
        }

        $data = app(CatalogController::class)(Request::create('/catalogo', 'GET', [
            'q' => 'a',
            'category' => 'inexistente',
            'brand' => 'inexistente',
        ]))->getData();

        $this->assertNull($data['category']);
        $this->assertNull($data['brand']);
        $this->assertSame(7, $data['perfumes']->total());
        $this->assertStringContainsString('q=a', $data['perfumes']->nextPageUrl());
    }
}
