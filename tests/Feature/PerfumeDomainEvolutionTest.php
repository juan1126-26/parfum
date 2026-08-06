<?php

namespace Tests\Feature;

use App\Enums\OlfactoryStage;
use App\Enums\PerformanceLevel;
use App\Models\Climate;
use App\Models\Note;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\PerfumeImage;
use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerfumeDomainEvolutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_perfume_supports_editorial_content_and_a_slug_route_key(): void
    {
        $perfume = Perfume::factory()->create([
            'longevity_level' => PerformanceLevel::Intense,
            'projection_level' => PerformanceLevel::Moderate,
            'intensity_level' => PerformanceLevel::Soft,
        ]);

        $this->assertSame('slug', $perfume->getRouteKeyName());
        $this->assertNotEmpty($perfume->editorial_story);
        $this->assertSame(PerformanceLevel::Intense, $perfume->longevity_level);
    }

    public function test_a_perfume_reuses_normalized_notes_recommendations_and_images(): void
    {
        $perfume = Perfume::factory()->create();
        $note = Note::factory()->create();
        $climate = Climate::factory()->create();
        $season = Season::factory()->create();
        $occasion = Occasion::factory()->create();

        $perfume->notes()->attach($note, ['stage' => OlfactoryStage::Top->value, 'sort_order' => 1]);
        $perfume->climates()->attach($climate);
        $perfume->seasons()->attach($season);
        $perfume->occasions()->attach($occasion);
        $image = PerfumeImage::factory()->for($perfume)->create(['is_cover' => true, 'sort_order' => 1]);

        $perfume->load('notes', 'climates', 'seasons', 'occasions', 'images');

        $this->assertSame(OlfactoryStage::Top, $perfume->notes->first()->pivot->stage);
        $this->assertTrue($perfume->climates->contains($climate));
        $this->assertTrue($perfume->seasons->contains($season));
        $this->assertTrue($perfume->occasions->contains($occasion));
        $this->assertTrue($perfume->images->contains($image));
    }
}
