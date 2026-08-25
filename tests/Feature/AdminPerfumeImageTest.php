<?php

namespace Tests\Feature;

use App\Models\Perfume;
use App\Models\PerfumeImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPerfumeImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_management_actions_require_administration(): void
    {
        $perfume = Perfume::factory()->create();

        $this->post(route('admin.perfumes.images.store', $perfume))
            ->assertRedirect(route('admin.login'));
    }

    public function test_administrator_can_upload_an_image_and_the_first_image_becomes_the_cover(): void
    {
        Storage::fake('public');
        $perfume = Perfume::factory()->create();

        $this->actingAs($this->administrator())
            ->post(route('admin.perfumes.images.store', $perfume), [
                'image' => UploadedFile::fake()->image('fragrance.jpg', 1200, 1200),
                'alt_text' => 'Frasco del perfume sobre una superficie oscura.',
            ])
            ->assertRedirect(route('admin.perfumes.edit', $perfume))
            ->assertSessionHas('success');

        $image = PerfumeImage::query()->where('perfume_id', $perfume->id)->firstOrFail();

        $this->assertTrue($image->is_cover);
        $this->assertSame(1, $image->sort_order);
        $this->assertSame('Frasco del perfume sobre una superficie oscura.', $image->alt_text);
        Storage::disk('public')->assertExists(str($image->path)->after('storage/')->toString());
    }

    public function test_invalid_image_upload_preserves_input_and_creates_no_image(): void
    {
        Storage::fake('public');
        $perfume = Perfume::factory()->create();

        $this->actingAs($this->administrator())
            ->from(route('admin.perfumes.edit', $perfume))
            ->post(route('admin.perfumes.images.store', $perfume), [
                'image' => UploadedFile::fake()->create('notas.pdf', 100, 'application/pdf'),
                'alt_text' => str_repeat('a', 256),
            ])
            ->assertRedirect(route('admin.perfumes.edit', $perfume))
            ->assertSessionHasErrors(['image', 'alt_text'])
            ->assertSessionHasInput('alt_text');

        $this->assertDatabaseCount('perfume_images', 0);
    }

    public function test_edit_page_lists_existing_images(): void
    {
        Storage::fake('public');
        $perfume = Perfume::factory()->create();
        $image = $this->imageFor($perfume, 'perfumes/'.$perfume->id.'/listing.jpg', 'Vista editorial del frasco.', true);

        $this->actingAs($this->administrator())
            ->get(route('admin.perfumes.edit', $perfume))
            ->assertOk()
            ->assertSee('Imagenes del perfume')
            ->assertSee($image->alt_text)
            ->assertSee('Portada');
    }

    public function test_administrator_can_update_image_metadata_and_change_the_cover(): void
    {
        Storage::fake('public');
        $perfume = Perfume::factory()->create();
        $firstImage = $this->imageFor($perfume, 'perfumes/'.$perfume->id.'/first.jpg', 'Primera imagen.', true, 1);
        $secondImage = $this->imageFor($perfume, 'perfumes/'.$perfume->id.'/second.jpg', 'Segunda imagen.', false, 2);

        $this->actingAs($this->administrator())
            ->put(route('admin.perfumes.images.update', [$perfume, $secondImage]), [
                'alt_text' => 'Nueva descripcion de la segunda imagen.',
                'sort_order' => 0,
            ])
            ->assertRedirect(route('admin.perfumes.edit', $perfume));

        $this->actingAs($this->administrator())
            ->patch(route('admin.perfumes.images.cover', [$perfume, $secondImage]))
            ->assertRedirect(route('admin.perfumes.edit', $perfume));

        $firstImage->refresh();
        $secondImage->refresh();

        $this->assertFalse($firstImage->is_cover);
        $this->assertTrue($secondImage->is_cover);
        $this->assertSame(0, $secondImage->sort_order);
        $this->assertSame('Nueva descripcion de la segunda imagen.', $secondImage->alt_text);
    }

    public function test_administrator_can_delete_an_image_and_its_file_while_preserving_a_cover_when_images_remain(): void
    {
        Storage::fake('public');
        $perfume = Perfume::factory()->create();
        $coverImage = $this->imageFor($perfume, 'perfumes/'.$perfume->id.'/cover.jpg', 'Portada.', true, 1);
        $nextImage = $this->imageFor($perfume, 'perfumes/'.$perfume->id.'/next.jpg', 'Alternativa.', false, 2);

        $this->actingAs($this->administrator())
            ->delete(route('admin.perfumes.images.destroy', [$perfume, $coverImage]))
            ->assertRedirect(route('admin.perfumes.edit', $perfume))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('perfume_images', ['id' => $coverImage->id]);
        Storage::disk('public')->assertMissing('perfumes/'.$perfume->id.'/cover.jpg');
        $this->assertTrue($nextImage->fresh()->is_cover);
    }

    public function test_an_image_cannot_be_managed_from_another_perfume(): void
    {
        $perfume = Perfume::factory()->create();
        $otherImage = PerfumeImage::factory()->create();

        $this->actingAs($this->administrator())
            ->patch(route('admin.perfumes.images.cover', [$perfume, $otherImage]))
            ->assertNotFound();
    }

    private function imageFor(Perfume $perfume, string $storedPath, string $altText, bool $isCover = false, int $sortOrder = 1): PerfumeImage
    {
        Storage::disk('public')->put($storedPath, 'image-content');

        return PerfumeImage::factory()->for($perfume)->create([
            'path' => 'storage/'.$storedPath,
            'alt_text' => $altText,
            'is_cover' => $isCover,
            'sort_order' => $sortOrder,
        ]);
    }

    private function administrator(): User
    {
        return User::factory()->create();
    }
}
