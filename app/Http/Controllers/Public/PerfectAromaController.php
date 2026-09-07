<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Services\RecommendationService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PerfectAromaController extends Controller
{
    public function index(): View
    {
        $questions = $this->questions();

        abort_if($questions->isEmpty(), 404);

        return view('public.perfect-aroma', [
            'activeRoute' => 'perfect-aroma',
            'questions' => $questions,
            'recommendations' => null,
            'title' => 'Mi Aroma Perfecto',
            'description' => 'Una guia personal para descubrir fragancias afines a tu momento y estilo.',
            'canonical' => route('perfect-aroma'),
        ]);
    }

    public function results(Request $request, RecommendationService $recommendationService): View
    {
        $questions = $this->questions();
        abort_if($questions->isEmpty(), 404);
        $answerOptionIds = $this->validatedAnswerOptionIds($request, $questions);
        $recommendations = $recommendationService->recommend($answerOptionIds->all());

        (new EloquentCollection($recommendations->pluck('perfume')->all()))->loadMissing([
            'brand',
            'coverImage',
        ]);

        return view('public.perfect-aroma', [
            'activeRoute' => 'perfect-aroma',
            'questions' => $questions,
            'recommendations' => $recommendations,
            'title' => 'Tu Aroma Perfecto',
            'description' => 'Una seleccion de fragancias elegida a partir de tus preferencias.',
            'canonical' => route('perfect-aroma'),
        ]);
    }

    /** @return Collection<int, Question> */
    private function questions(): Collection
    {
        return Question::query()
            ->where('is_active', true)
            ->with(['options' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();
    }

    /** @param Collection<int, Question> $questions */
    private function validatedAnswerOptionIds(Request $request, Collection $questions): Collection
    {
        $request->validate([
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'array', 'min:1'],
            'answers.*.*' => ['integer'],
        ]);

        $submittedAnswers = collect($request->input('answers'))
            ->map(fn (array $answerIds): Collection => collect($answerIds)->map(fn ($id): int => (int) $id)->unique()->values());
        $requiredQuestionIds = $questions->where('is_required', true)->modelKeys();
        $questionIds = $questions->modelKeys();

        if (collect($requiredQuestionIds)->diff($submittedAnswers->keys())->isNotEmpty() || $submittedAnswers->keys()->diff($questionIds)->isNotEmpty()) {
            abort(422, 'Selecciona una opcion para cada pregunta obligatoria.');
        }

        $answerOptionIds = $submittedAnswers->flatten()->unique()->values();
        $answerOptions = AnswerOption::query()
            ->where('is_active', true)
            ->whereHas('question', fn ($query) => $query->where('is_active', true))
            ->whereIn('id', $answerOptionIds)
            ->get()
            ->keyBy('id');

        $belongsToSubmittedQuestion = $submittedAnswers->every(
            fn (Collection $answerIds, int|string $questionId): bool => $answerIds->every(
                fn (int $answerId): bool => $answerOptions->get($answerId)?->question_id === (int) $questionId,
            ),
        );

        abort_unless($answerOptions->count() === $answerOptionIds->count() && $belongsToSubmittedQuestion, 422, 'Las respuestas seleccionadas no son validas.');

        return $answerOptionIds;
    }
}
