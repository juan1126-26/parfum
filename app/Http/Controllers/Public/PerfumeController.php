<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Perfume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PerfumeController extends Controller
{
    public function __invoke(Perfume $perfume): View
    {
        abort_unless($perfume->is_active && $perfume->brand()->where('is_active', true)->exists() && $perfume->category()->where('is_active', true)->exists(), 404);

        $perfume->load([
            'brand',
            'category',
            'accords' => fn (BelongsToMany $query) => $query->active()->orderByPivotDesc('is_primary')->orderByPivot('sort_order'),
            'notes' => fn (BelongsToMany $query) => $query->active()->orderByPivot('stage')->orderByPivot('sort_order'),
            'climates' => fn ($query) => $query->active()->ordered(),
            'seasons' => fn ($query) => $query->active()->ordered(),
            'occasions' => fn ($query) => $query->active()->ordered(),
            'images',
        ]);

        $images = $perfume->images->filter(fn ($image) => $this->hasPublicImage($image->path))->values();
        $perfume->setRelation('images', $images);

        $relatedPerfumes = $this->relatedPerfumes($perfume);

        return view('public.perfume', [
            'activeRoute' => 'catalog',
            'perfume' => $perfume,
            'coverImage' => $images->firstWhere('is_cover', true) ?? $images->first(),
            'notesByStage' => $perfume->notes->groupBy(fn ($note) => $note->pivot->stage->value),
            'relatedPerfumes' => $relatedPerfumes,
            'title' => $perfume->name,
            'description' => str($perfume->short_description ?: $perfume->description ?: config('parfum.brand.description'))->limit(155),
            'canonical' => route('catalog.show', $perfume),
        ]);
    }

    private function relatedPerfumes(Perfume $perfume): Collection
    {
        $related = $this->publicPerfumes()
            ->with($this->cardRelations())
            ->whereKeyNot($perfume->getKey())
            ->where('category_id', $perfume->category_id)
            ->ordered()
            ->limit(3)
            ->get();

        if ($related->count() < 3 && $perfume->accords->isNotEmpty()) {
            $related = $related->concat(
                $this->publicPerfumes()
                    ->with($this->cardRelations())
                    ->whereKeyNot($perfume->getKey())
                    ->whereNotIn('id', $related->modelKeys())
                    ->whereHas('accords', fn (Builder $query) => $query->whereIn('accords.id', $perfume->accords->modelKeys()))
                    ->ordered()
                    ->limit(3 - $related->count())
                    ->get(),
            );
        }

        return $related->each(fn (Perfume $item) => $item->setRelation('accords', $item->accords->take(3)));
    }

    private function publicPerfumes(): Builder
    {
        return Perfume::query()
            ->active()
            ->whereHas('brand', fn (Builder $query) => $query->where('is_active', true))
            ->whereHas('category', fn (Builder $query) => $query->active());
    }

    private function cardRelations(): array
    {
        return [
            'brand',
            'category',
            'accords' => fn (BelongsToMany $query) => $query->active()->orderByPivotDesc('is_primary')->orderByPivot('sort_order'),
        ];
    }

    private function hasPublicImage(string $path): bool
    {
        return ! str_contains($path, '..') && is_file(public_path($path));
    }
}
