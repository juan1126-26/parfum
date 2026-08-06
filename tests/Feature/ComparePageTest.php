<?php

namespace Tests\Feature;

use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComparePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_comparator_handles_initial_selection_and_valid_comparison(): void
    {
        $first = Perfume::factory()->create(['slug' => 'primero']);
        $second = Perfume::factory()->create(['slug' => 'segundo']);

        $this->get(route('comparator'))->assertOk()->assertSee('Dos aromas');
        $this->get(route('comparator', ['first' => $first->slug]))->assertOk()->assertSee($first->name);
        $this->get(route('comparator', ['first' => $first->slug, 'second' => $second->slug]))->assertOk()->assertSee($second->name);
        $this->get(route('comparator', ['first' => $first->slug, 'second' => $second->slug]))
            ->assertSee('target="_blank"', false)
            ->assertSee('rel="noopener noreferrer"', false)
            ->assertSee('No existen coincidencias registradas en este aspecto.')
            ->assertDontSee('Coinciden en');
    }

    public function test_comparator_rejects_identical_and_inactive_selections(): void
    {
        $perfume = Perfume::factory()->create(['slug' => 'igual']);
        $inactive = Perfume::factory()->create(['slug' => 'oculto', 'is_active' => false]);

        $this->get(route('comparator', ['first' => $perfume->slug, 'second' => $perfume->slug]))->assertOk()->assertSee('Elige dos perfumes diferentes');
        $this->get(route('comparator', ['first' => $inactive->slug]))->assertOk()->assertSee('no está disponible');
    }
}
