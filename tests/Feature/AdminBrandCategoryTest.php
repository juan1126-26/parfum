<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBrandCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_and_category_listings_require_administration_and_preserve_search_pagination(): void
    {
        $this->get(route('admin.brands.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.categories.index'))->assertRedirect(route('admin.login'));

        Brand::factory()->count(13)->create(['country' => 'Colombia']);
        Category::factory()->count(13)->create();

        $this->actingAs($this->administrator())
            ->get(route('admin.brands.index', ['q' => 'Colombia']))
            ->assertOk()
            ->assertViewHas('brands', fn ($brands): bool => $brands->total() === 13
                && $brands->perPage() === 12
                && str_contains($brands->nextPageUrl(), 'q=Colombia'));

        $category = Category::query()->firstOrFail();

        $this->actingAs($this->administrator())
            ->get(route('admin.categories.index', ['q' => $category->slug]))
            ->assertOk()
            ->assertSee($category->name)
            ->assertViewHas('categories', fn ($categories): bool => $categories->total() === 1);
    }

    public function test_administrator_can_create_validate_edit_and_toggle_a_brand_without_deleting_it(): void
    {
        $payload = [
            'name' => 'Maison Serena',
            'slug' => 'maison-serena',
            'description' => 'Una casa de composiciones sobrias.',
            'country' => 'Francia',
            'sort_order' => 3,
        ];

        $this->actingAs($this->administrator())
            ->post(route('admin.brands.store'), $payload)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('success');

        $brand = Brand::query()->where('slug', 'maison-serena')->firstOrFail();
        $this->assertSame('Francia', $brand->country);
        $this->assertTrue($brand->is_active);

        $this->actingAs($this->administrator())
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), ['name' => '', 'slug' => 'slug invalido', 'sort_order' => -1])
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors(['name', 'slug', 'sort_order'])
            ->assertSessionHasInput('slug', 'slug invalido');

        $this->actingAs($this->administrator())
            ->put(route('admin.brands.update', $brand), [...$payload, 'name' => 'Maison Renovee', 'slug' => 'maison-renovee'])
            ->assertRedirect(route('admin.brands.edit', 'maison-renovee'));

        $brand->refresh();
        $this->assertSame('Maison Renovee', $brand->name);
        $this->assertSame('maison-renovee', $brand->slug);

        $this->actingAs($this->administrator())
            ->patch(route('admin.brands.toggle', $brand))
            ->assertRedirect();

        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'is_active' => false]);
        $this->assertDatabaseCount('brands', 1);
    }

    public function test_administrator_can_create_validate_edit_and_toggle_a_category_without_deleting_it(): void
    {
        $payload = [
            'name' => 'Selecciones Serenas',
            'slug' => 'selecciones-serenas',
            'description' => 'Una categoria editorial.',
            'sort_order' => 4,
        ];

        $this->actingAs($this->administrator())
            ->post(route('admin.categories.store'), $payload)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success');

        $category = Category::query()->where('slug', 'selecciones-serenas')->firstOrFail();
        Perfume::factory()->for($category)->create();

        $this->actingAs($this->administrator())
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), ['name' => '', 'slug' => 'slug invalido', 'sort_order' => -1])
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors(['name', 'slug', 'sort_order'])
            ->assertSessionHasInput('slug', 'slug invalido');

        $this->actingAs($this->administrator())
            ->put(route('admin.categories.update', $category), [...$payload, 'name' => 'Selecciones Renovadas', 'slug' => 'selecciones-renovadas'])
            ->assertRedirect(route('admin.categories.edit', 'selecciones-renovadas'));

        $category->refresh();
        $this->assertSame('Selecciones Renovadas', $category->name);
        $this->assertSame('selecciones-renovadas', $category->slug);

        $this->actingAs($this->administrator())
            ->patch(route('admin.categories.toggle', $category))
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'is_active' => false]);
        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseCount('perfumes', 1);
    }

    private function administrator(): User
    {
        return User::factory()->create();
    }
}
