<?php

namespace App\Services;

use App\Enums\RecommendationCriterion;
use App\Models\Perfume;
use App\Models\RecommendationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * @param  array<int, int|string>  $answers
     * @return Collection<int, array{perfume: Perfume, score: int, affinity_percentage: int, affinity_level: string, matches: array<int, array{criterion: string, label: string, answer: string, weight: int}>, reasons: array<int, string>}>
     */
    public function recommend(array $answers, ?int $limit = null): Collection
    {
        $answerOptionIds = collect($answers)
            ->filter(fn (mixed $answer): bool => is_int($answer) || (is_string($answer) && ctype_digit($answer)))
            ->map(fn (int|string $answer): int => (int) $answer)
            ->unique()
            ->values();

        if ($answerOptionIds->isEmpty()) {
            return collect();
        }

        $rules = RecommendationRule::query()
            ->with('answerOption')
            ->where('is_active', true)
            ->whereIn('answer_option_id', $answerOptionIds)
            ->whereHas('answerOption', fn (Builder $query) => $query->where('is_active', true)->whereHas('question', fn (Builder $query) => $query->where('is_active', true)))
            ->orderByDesc('weight')
            ->get();

        if ($rules->isEmpty()) {
            return collect();
        }

        $limit ??= (int) config('parfum.recommendations.result_limit', 3);
        $maximumScore = max(1, $rules->sum('weight'));

        return Perfume::query()
            ->active()
            ->with($this->perfumeRelations())
            ->ordered()
            ->get()
            ->map(function (Perfume $perfume) use ($rules, $maximumScore): array {
                $matches = $rules
                    ->filter(fn (RecommendationRule $rule): bool => $this->matches($perfume, $rule))
                    ->map(fn (RecommendationRule $rule): array => $this->matchDetails($rule))
                    ->values()
                    ->all();
                $score = collect($matches)->sum('weight');
                $affinityPercentage = (int) round(($score / $maximumScore) * 100);

                return [
                    'perfume' => $perfume,
                    'score' => $score,
                    'affinity_percentage' => $affinityPercentage,
                    'affinity_level' => $this->affinityLevel($affinityPercentage),
                    'matches' => $matches,
                    'reasons' => collect($matches)->sortByDesc('weight')->pluck('answer')->take(3)->values()->all(),
                ];
            })
            ->filter(fn (array $result): bool => $result['score'] > 0)
            ->sortByDesc('score')
            ->take(max(0, $limit))
            ->values();
    }

    private function perfumeRelations(): array
    {
        return [
            'accords' => fn ($query) => $query->active(),
            'occasions' => fn ($query) => $query->active(),
            'climates' => fn ($query) => $query->active(),
        ];
    }

    private function matches(Perfume $perfume, RecommendationRule $rule): bool
    {
        return match ($rule->criterion) {
            RecommendationCriterion::Accord => $perfume->accords->contains('id', $rule->target_id),
            RecommendationCriterion::Occasion => $perfume->occasions->contains('id', $rule->target_id),
            RecommendationCriterion::Climate => $perfume->climates->contains('id', $rule->target_id),
            RecommendationCriterion::Duration => $perfume->longevity_level?->value === $rule->target_value,
            RecommendationCriterion::Projection => $perfume->projection_level?->value === $rule->target_value,
            RecommendationCriterion::Intensity => $perfume->intensity_level?->value === $rule->target_value,
        };
    }

    /** @return array{criterion: string, label: string, answer: string, weight: int} */
    private function matchDetails(RecommendationRule $rule): array
    {
        return [
            'criterion' => $rule->criterion->value,
            'label' => $rule->criterion->label(),
            'answer' => $rule->answerOption->label,
            'weight' => $rule->weight,
        ];
    }

    private function affinityLevel(int $affinityPercentage): string
    {
        return match (true) {
            $affinityPercentage >= 85 => 'Afinidad excepcional',
            $affinityPercentage >= 60 => 'Afinidad alta',
            default => 'Afinidad inicial',
        };
    }
}
