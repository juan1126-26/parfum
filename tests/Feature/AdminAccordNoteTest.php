<?php

namespace Tests\Feature;

use App\Models\Accord;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccordNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_accord_and_note_listings_require_administration_and_preserve_search_pagination(): void
    {
        $this->get(route('admin.accords.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.notes.index'))->assertRedirect(route('admin.login'));

        Accord::factory()->count(13)->create(['name' => 'Perfil de prueba']);
        Note::factory()->count(13)->create(['name' => 'Materia de prueba']);

        $this->actingAs($this->administrator())
            ->get(route('admin.accords.index', ['q' => 'Perfil']))
            ->assertOk()
            ->assertViewHas('accords', fn ($accords): bool => $accords->total() === 13
                && $accords->perPage() === 12
                && str_contains($accords->nextPageUrl(), 'q=Perfil'));

        $this->actingAs($this->administrator())
            ->get(route('admin.notes.index', ['q' => 'Materia']))
            ->assertOk()
            ->assertViewHas('notes', fn ($notes): bool => $notes->total() === 13
                && $notes->perPage() === 12
                && str_contains($notes->nextPageUrl(), 'q=Materia'));
    }

    public function test_administrator_can_create_validate_edit_and_toggle_an_accord_without_deleting_it(): void
    {
        $payload = [
            'name' => 'Resinoso',
            'slug' => 'resinoso',
            'description' => 'Un acorde calido y profundo.',
            'color' => '#B28A43',
            'sort_order' => 3,
        ];

        $this->actingAs($this->administrator())
            ->post(route('admin.accords.store'), $payload)
            ->assertRedirect(route('admin.accords.index'))
            ->assertSessionHas('success');

        $accord = Accord::query()->where('slug', 'resinoso')->firstOrFail();

        $this->actingAs($this->administrator())
            ->from(route('admin.accords.create'))
            ->post(route('admin.accords.store'), ['name' => '', 'slug' => 'slug invalido', 'color' => 'blue', 'sort_order' => -1])
            ->assertRedirect(route('admin.accords.create'))
            ->assertSessionHasErrors(['name', 'slug', 'color', 'sort_order'])
            ->assertSessionHasInput('slug', 'slug invalido');

        $this->actingAs($this->administrator())
            ->put(route('admin.accords.update', $accord), [...$payload, 'name' => 'Resinoso Renovado', 'slug' => 'resinoso-renovado'])
            ->assertRedirect(route('admin.accords.edit', 'resinoso-renovado'));

        $accord->refresh();
        $this->assertSame('Resinoso Renovado', $accord->name);
        $this->assertSame('resinoso-renovado', $accord->slug);

        $this->actingAs($this->administrator())
            ->patch(route('admin.accords.toggle', $accord))
            ->assertRedirect();

        $this->assertDatabaseHas('accords', ['id' => $accord->id, 'is_active' => false]);
        $this->assertDatabaseCount('accords', 1);
    }

    public function test_administrator_can_create_validate_edit_and_toggle_a_note_without_deleting_it(): void
    {
        $payload = [
            'name' => 'Neroli',
            'slug' => 'neroli',
            'description' => 'Una nota floral luminosa.',
            'sort_order' => 4,
        ];

        $this->actingAs($this->administrator())
            ->post(route('admin.notes.store'), $payload)
            ->assertRedirect(route('admin.notes.index'))
            ->assertSessionHas('success');

        $note = Note::query()->where('slug', 'neroli')->firstOrFail();

        $this->actingAs($this->administrator())
            ->from(route('admin.notes.create'))
            ->post(route('admin.notes.store'), ['name' => '', 'slug' => 'slug invalido', 'sort_order' => -1])
            ->assertRedirect(route('admin.notes.create'))
            ->assertSessionHasErrors(['name', 'slug', 'sort_order'])
            ->assertSessionHasInput('slug', 'slug invalido');

        $this->actingAs($this->administrator())
            ->put(route('admin.notes.update', $note), [...$payload, 'name' => 'Neroli Renovado', 'slug' => 'neroli-renovado'])
            ->assertRedirect(route('admin.notes.edit', 'neroli-renovado'));

        $note->refresh();
        $this->assertSame('Neroli Renovado', $note->name);
        $this->assertSame('neroli-renovado', $note->slug);

        $this->actingAs($this->administrator())
            ->patch(route('admin.notes.toggle', $note))
            ->assertRedirect();

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'is_active' => false]);
        $this->assertDatabaseCount('notes', 1);
    }

    public function test_administrative_cancel_actions_use_the_readable_secondary_button_style(): void
    {
        $this->actingAs($this->administrator())
            ->get(route('admin.accords.create'))
            ->assertOk()
            ->assertSee('admin-button admin-button--secondary', false);
    }

    private function administrator(): User
    {
        return User::factory()->create();
    }
}
