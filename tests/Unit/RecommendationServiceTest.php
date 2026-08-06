<?php

namespace Tests\Unit;

use App\Enums\PerformanceLevel;
use App\Enums\RecommendationCriterion;
use App\Models\Accord;
use App\Models\AnswerOption;
use App\Models\Climate;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\Question;
use App\Models\RecommendationRule;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_scores_matches_with_primary_criteria_before_performance(): void
    {
        $accord = Accord::factory()->create();
        $occasion = Occasion::factory()->create();
        $climate = Climate::factory()->create();
        $bestMatch = Perfume::factory()->create([
            'longevity_level' => PerformanceLevel::Intense,
            'projection_level' => PerformanceLevel::Moderate,
            'intensity_level' => PerformanceLevel::Soft,
        ]);
        $accordOnly = Perfume::factory()->create();
        $inactive = Perfume::factory()->create(['is_active' => false]);

        foreach ([$bestMatch, $inactive] as $perfume) {
            $perfume->accords()->attach($accord, ['intensity' => 80, 'sort_order' => 1, 'is_primary' => true]);
            $perfume->occasions()->attach($occasion);
            $perfume->climates()->attach($climate);
        }
        $accordOnly->accords()->attach($accord, ['intensity' => 80, 'sort_order' => 1, 'is_primary' => true]);

        $answers = [
            $this->answerFor(RecommendationCriterion::Accord, 50, $accord->id),
            $this->answerFor(RecommendationCriterion::Occasion, 30, $occasion->id),
            $this->answerFor(RecommendationCriterion::Climate, 20, $climate->id),
            $this->answerFor(RecommendationCriterion::Duration, 12, null, PerformanceLevel::Intense->value),
            $this->answerFor(RecommendationCriterion::Projection, 8, null, PerformanceLevel::Moderate->value),
            $this->answerFor(RecommendationCriterion::Intensity, 8, null, PerformanceLevel::Soft->value),
        ];

        $results = app(RecommendationService::class)->recommend(collect($answers)->pluck('id')->all(), 5);

        $this->assertSame([$bestMatch->id, $accordOnly->id], $results->pluck('perfume.id')->all());
        $this->assertSame(128, $results->first()['score']);
        $this->assertSame(100, $results->first()['affinity_percentage']);
        $this->assertSame('Afinidad excepcional', $results->first()['affinity_level']);
        $this->assertCount(6, $results->first()['matches']);
        $this->assertSame('Acorde', $results->first()['matches'][0]['label']);
        $this->assertCount(3, $results->first()['reasons']);
    }

    public function test_it_honors_the_configurable_result_limit_and_ignores_inactive_rules(): void
    {
        $accord = Accord::factory()->create();
        $first = Perfume::factory()->create(['sort_order' => 1]);
        $second = Perfume::factory()->create(['sort_order' => 2]);
        $first->accords()->attach($accord, ['intensity' => 70, 'sort_order' => 1, 'is_primary' => true]);
        $second->accords()->attach($accord, ['intensity' => 70, 'sort_order' => 1, 'is_primary' => true]);
        $answer = $this->answerFor(RecommendationCriterion::Accord, 50, $accord->id);

        $this->assertSame([$first->id], app(RecommendationService::class)->recommend([$answer->id], 1)->pluck('perfume.id')->all());

        $answer->rules()->update(['is_active' => false]);
        $this->assertTrue(app(RecommendationService::class)->recommend([$answer->id])->isEmpty());
    }

    private function answerFor(RecommendationCriterion $criterion, int $weight, ?int $targetId = null, ?string $targetValue = null): AnswerOption
    {
        $question = Question::query()->create([
            'text' => $criterion->label(),
            'criterion' => $criterion,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $answer = $question->options()->create(['label' => $criterion->label(), 'value' => $criterion->value, 'is_active' => true, 'sort_order' => 1]);
        RecommendationRule::query()->create([
            'answer_option_id' => $answer->id,
            'criterion' => $criterion,
            'target_id' => $targetId,
            'target_value' => $targetValue,
            'weight' => $weight,
            'is_active' => true,
        ]);

        return $answer;
    }
}
