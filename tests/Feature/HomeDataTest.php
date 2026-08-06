<?php

namespace Tests\Feature;

use App\Http\Controllers\Public\HomeController;
use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_controller_only_returns_active_ordered_home_data(): void
    {
        $brand = Brand::factory()->create();
        $firstCategory = Category::factory()->create(['sort_order' => 1]);
        $secondCategory = Category::factory()->create(['sort_order' => 2]);
        Category::factory()->create(['is_active' => false]);

        $featuredPerfume = Perfume::factory()->for($brand)->for($secondCategory)->create([
            'is_featured' => true,
            'sort_order' => 2,
        ]);
        $bestSeller = Perfume::factory()->for($brand)->for($firstCategory)->create([
            'is_best_seller' => true,
            'sort_order' => 1,
        ]);
        Perfume::factory()->for($brand)->for($firstCategory)->create([
            'is_featured' => true,
            'is_active' => false,
        ]);

        $accord = Accord::factory()->create(['sort_order' => 1]);
        $inactiveAccord = Accord::factory()->create(['is_active' => false, 'sort_order' => 2]);
        $featuredPerfume->accords()->attach($accord, [
            'intensity' => 76,
            'sort_order' => 1,
            'is_primary' => true,
        ]);
        $featuredPerfume->accords()->attach($inactiveAccord, [
            'intensity' => 40,
            'sort_order' => 2,
            'is_primary' => false,
        ]);

        $data = app(HomeController::class)()->getData();

        $this->assertSame([$firstCategory->id, $secondCategory->id], $data['categories']->pluck('id')->all());
        $this->assertSame([$bestSeller->id, $featuredPerfume->id], $data['featuredPerfumes']->pluck('id')->all());
        $this->assertTrue($data['featuredPerfumes']->every(fn (Perfume $perfume) => $perfume->relationLoaded('brand') && $perfume->relationLoaded('category')));
        $this->assertSame([$accord->id], $data['accords']->pluck('id')->all());
        $this->assertSame(76, $data['accords']->first()->pivot->intensity);
    }
}
