<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Perfume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function __invoke(Request $request): View
    {
        $options = $this->publicPerfumes()->with(['brand', 'category'])->ordered()->get();
        $firstSlug = $request->string('first')->trim()->toString();
        $secondSlug = $request->string('second')->trim()->toString();
        $selected = $this->publicPerfumes()->with($this->relations())->whereIn('slug', array_filter([$firstSlug, $secondSlug]))->get()->keyBy('slug');
        $first = $selected->get($firstSlug);
        $second = $selected->get($secondSlug);
        $message = null;

        if (($firstSlug && ! $first) || ($secondSlug && ! $second)) {
            $message = 'Uno de los perfumes seleccionados no está disponible.';
        }
        if ($first && $second && $first->is($second)) {
            $second = null;
            $message = 'Elige dos perfumes diferentes para apreciar sus matices.';
        }

        return view('public.compare', [
            'activeRoute' => 'comparator', 'options' => $options, 'first' => $first, 'second' => $second, 'message' => $message,
            'comparison' => $first && $second ? $this->comparison($first, $second) : null,
            'title' => $first && $second ? "{$first->name} y {$second->name}" : 'Comparador',
            'description' => 'Compara composiciones, rendimiento y momentos ideales entre fragancias Parfum.',
            'canonical' => route('comparator'),
        ]);
    }

    private function publicPerfumes(): Builder
    {
        return Perfume::query()->active()->whereHas('brand', fn (Builder $q) => $q->where('is_active', true))->whereHas('category', fn (Builder $q) => $q->active());
    }

    private function relations(): array
    {
        return ['brand', 'category', 'accords' => fn (BelongsToMany $q) => $q->active()->orderByPivotDesc('is_primary')->orderByPivot('sort_order'), 'notes' => fn (BelongsToMany $q) => $q->active()->orderByPivot('sort_order'), 'climates' => fn ($q) => $q->active()->ordered(), 'seasons' => fn ($q) => $q->active()->ordered(), 'occasions' => fn ($q) => $q->active()->ordered()];
    }

    private function comparison(Perfume $first, Perfume $second): array
    {
        $sets = collect(['accords', 'notes', 'climates', 'seasons', 'occasions'])->mapWithKeys(fn ($relation) => [$relation => $this->sets($first->$relation, $second->$relation)]);
        $metrics = collect(['Duración' => ['first' => $first->longevity_level, 'second' => $second->longevity_level], 'Proyección' => ['first' => $first->projection_level, 'second' => $second->projection_level], 'Intensidad' => ['first' => $first->intensity_level, 'second' => $second->intensity_level]])->filter(fn ($item) => $item['first'] || $item['second']);
        $summary = $metrics->filter(fn ($item) => $item['first'] && $item['second'] && $item['first']->value !== $item['second']->value)->map(fn ($item, $name) => $item['first']->value > $item['second']->value ? "{$first->name} presenta {$name} más marcada." : "{$second->name} presenta {$name} más marcada.")->values();
        if ($sets['accords']['shared']->isNotEmpty()) {
            $summary->push('Comparten acordes '.$sets['accords']['shared']->pluck('name')->join(', ').'.');
        }

        return compact('sets', 'metrics', 'summary');
    }

    private function sets(Collection $first, Collection $second): array
    {
        $secondIds = $second->modelKeys();
        $firstIds = $first->modelKeys();

        return ['shared' => $first->whereIn('id', $secondIds)->values(), 'first' => $first->whereNotIn('id', $secondIds)->values(), 'second' => $second->whereNotIn('id', $firstIds)->values()];
    }
}
