<?php

namespace Database\Seeders;

use App\Enums\PerformanceLevel;
use App\Enums\RecommendationCriterion;
use App\Models\Accord;
use App\Models\AnswerOption;
use App\Models\Climate;
use App\Models\Occasion;
use App\Models\Question;
use App\Models\RecommendationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $questions = collect([
            [RecommendationCriterion::Occasion, 'En que ocasion usaras el perfume?', 'Elige el momento para el que buscas una fragancia.', 1],
            [RecommendationCriterion::Climate, 'En que clima lo usaras?', 'Considera la temperatura habitual de ese momento.', 2],
            [RecommendationCriterion::Accord, 'Que acordes prefieres?', 'Puedes elegir los matices que mas te atraen.', 3],
            [RecommendationCriterion::Duration, 'Que duracion buscas?', 'Selecciona cuanto deseas que permanezca el aroma.', 4],
            [RecommendationCriterion::Projection, 'Que proyeccion prefieres?', 'Define como quieres que se perciba tu estela.', 5],
            [RecommendationCriterion::Intensity, 'Que intensidad buscas?', 'Indica la presencia general que esperas.', 6],
        ])->mapWithKeys(function (array $question): array {
            [$criterion, $text, $description, $sortOrder] = $question;

            $model = Question::query()->updateOrCreate(
                ['criterion' => $criterion->value],
                ['text' => $text, 'description' => $description, 'is_required' => true, 'is_active' => true, 'sort_order' => $sortOrder],
            );

            return [$criterion->value => $model];
        });

        $this->seedTaxonomyOptions($questions[RecommendationCriterion::Occasion->value], Occasion::query()->active()->ordered()->get(), RecommendationCriterion::Occasion, 30);
        $this->seedTaxonomyOptions($questions[RecommendationCriterion::Climate->value], Climate::query()->active()->ordered()->get(), RecommendationCriterion::Climate, 20);
        $this->seedTaxonomyOptions($questions[RecommendationCriterion::Accord->value], Accord::query()->active()->ordered()->get(), RecommendationCriterion::Accord, 50);
        $this->seedPerformanceOptions($questions[RecommendationCriterion::Duration->value], RecommendationCriterion::Duration, 12);
        $this->seedPerformanceOptions($questions[RecommendationCriterion::Projection->value], RecommendationCriterion::Projection, 8);
        $this->seedPerformanceOptions($questions[RecommendationCriterion::Intensity->value], RecommendationCriterion::Intensity, 8);
    }

    /** @param Collection<int, Model> $targets */
    private function seedTaxonomyOptions(Question $question, Collection $targets, RecommendationCriterion $criterion, int $weight): void
    {
        $targets->each(function (Model $target) use ($question, $criterion, $weight): void {
            $option = AnswerOption::query()->updateOrCreate(
                ['question_id' => $question->id, 'value' => $target->slug],
                ['label' => $target->name, 'description' => null, 'is_active' => true, 'sort_order' => $target->sort_order],
            );

            $this->seedRule($option, $criterion, $weight, $target->id);
        });
    }

    private function seedPerformanceOptions(Question $question, RecommendationCriterion $criterion, int $weight): void
    {
        foreach (PerformanceLevel::cases() as $sortOrder => $level) {
            $option = AnswerOption::query()->updateOrCreate(
                ['question_id' => $question->id, 'value' => $level->value],
                ['label' => $level->label(), 'description' => null, 'is_active' => true, 'sort_order' => $sortOrder + 1],
            );

            $this->seedRule($option, $criterion, $weight, null, $level->value);
        }
    }

    private function seedRule(AnswerOption $option, RecommendationCriterion $criterion, int $weight, ?int $targetId = null, ?string $targetValue = null): void
    {
        RecommendationRule::query()->updateOrCreate(
            ['answer_option_id' => $option->id, 'criterion' => $criterion->value, 'target_id' => $targetId, 'target_value' => $targetValue],
            ['weight' => $weight, 'is_active' => true],
        );
    }
}
