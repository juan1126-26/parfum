<?php

namespace Tests\Feature;

use App\Enums\RecommendationCriterion;
use App\Models\Accord;
use App\Models\AnswerOption;
use App\Models\Perfume;
use App\Models\Question;
use App\Models\RecommendationRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerfectAromaPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_journey_only_shows_active_questions_and_options_in_order(): void
    {
        $later = $this->question(RecommendationCriterion::Climate, 2);
        $first = $this->question(RecommendationCriterion::Occasion, 1);
        $inactive = $this->question(RecommendationCriterion::Accord, 3, false);
        $activeOption = $this->option($first, 'Uso diario', 'uso-diario', 1);
        $inactiveOption = $this->option($first, 'Oculta', 'oculta', 2, false);

        $this->get(route('perfect-aroma'))
            ->assertOk()
            ->assertViewHas('questions', fn ($questions) => $questions->pluck('id')->all() === [$first->id, $later->id])
            ->assertSee($activeOption->label)
            ->assertDontSee($inactiveOption->label)
            ->assertDontSee($inactive->text)
            ->assertSee('Pregunta 1 de 2')
            ->assertSee('Comenzar la experiencia')
            ->assertSee('Finalizar y ver mi seleccion')
            ->assertDontSee('Estamos afinando esta experiencia');
    }

    public function test_the_journey_does_not_render_an_incomplete_experience_without_questions(): void
    {
        $this->get(route('perfect-aroma'))->assertNotFound();
    }

    public function test_results_are_calculated_by_the_recommendation_service(): void
    {
        $accord = Accord::factory()->create(['name' => 'Ambar']);
        $perfume = Perfume::factory()->create(['name' => 'Velo Personal']);
        $perfume->accords()->attach($accord, ['intensity' => 88, 'sort_order' => 1, 'is_primary' => true]);
        $question = $this->question(RecommendationCriterion::Accord, 1);
        $option = $this->option($question, 'Ambar', 'ambar', 1);
        RecommendationRule::query()->create([
            'answer_option_id' => $option->id,
            'criterion' => RecommendationCriterion::Accord,
            'target_id' => $accord->id,
            'weight' => 50,
            'is_active' => true,
        ]);

        $this->post(route('perfect-aroma.results'), ['answers' => [$question->id => [$option->id]]])
            ->assertOk()
            ->assertSee('Velo Personal')
            ->assertSee('100%')
            ->assertSee('Afinidad excepcional')
            ->assertViewHas('recommendations', fn ($recommendations) => $recommendations->first()['perfume']->is($perfume));
    }

    public function test_results_reject_options_that_do_not_belong_to_the_submitted_question(): void
    {
        $firstQuestion = $this->question(RecommendationCriterion::Occasion, 1);
        $secondQuestion = $this->question(RecommendationCriterion::Climate, 2);
        $secondQuestion->update(['is_required' => false]);
        $foreignOption = $this->option($secondQuestion, 'Calido', 'calido', 1);

        $this->post(route('perfect-aroma.results'), ['answers' => [$firstQuestion->id => [$foreignOption->id]]])
            ->assertUnprocessable();
    }

    private function question(RecommendationCriterion $criterion, int $sortOrder, bool $active = true): Question
    {
        return Question::query()->create([
            'text' => $criterion->label(),
            'criterion' => $criterion,
            'is_required' => true,
            'is_active' => $active,
            'sort_order' => $sortOrder,
        ]);
    }

    private function option(Question $question, string $label, string $value, int $sortOrder, bool $active = true): AnswerOption
    {
        return $question->options()->create([
            'label' => $label,
            'value' => $value,
            'is_active' => $active,
            'sort_order' => $sortOrder,
        ]);
    }
}
