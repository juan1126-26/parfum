<?php

namespace Tests\Feature;

use App\Enums\RecommendationCriterion;
use App\Models\Accord;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\RecommendationRule;
use Database\Seeders\ParfumDemoSeeder;
use Database\Seeders\RecommendationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_recommendation_seeders_are_idempotent_and_reuse_catalog_taxonomies(): void
    {
        $this->seed(ParfumDemoSeeder::class);
        $this->seed(RecommendationSeeder::class);
        $this->seed(RecommendationSeeder::class);

        $this->assertSame(6, Question::query()->count());
        $this->assertSame(27, AnswerOption::query()->count());
        $this->assertSame(27, RecommendationRule::query()->count());

        $accord = Accord::query()->where('slug', 'dulce')->firstOrFail();
        $option = AnswerOption::query()
            ->whereHas('question', fn ($query) => $query->where('criterion', RecommendationCriterion::Accord->value))
            ->where('value', $accord->slug)
            ->firstOrFail();
        $rule = $option->rules()->firstOrFail();

        $this->assertSame(RecommendationCriterion::Accord, $rule->criterion);
        $this->assertSame($accord->id, $rule->target_id);
        $this->assertSame(50, $rule->weight);
    }
}
