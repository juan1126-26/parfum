<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(Request $request): View
    {
        $categories = Category::query()
            ->active()
            ->whereHas('perfumes', fn (Builder $query) => $this->publicPerfumes($query))
            ->ordered()
            ->get();

        $brands = Brand::query()
            ->where('is_active', true)
            ->whereHas('perfumes', fn (Builder $query) => $this->publicPerfumes($query))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $search = trim((string) $request->query('q', ''));
        $category = $this->validFilter($request->query('category'), $categories);
        $brand = $this->validFilter($request->query('brand'), $brands);

        $perfumes = Perfume::query()
            ->with([
                'brand',
                'category',
                'coverImage',
                'accords' => fn (BelongsToMany $query) => $query
                    ->active()
                    ->orderByPivotDesc('is_primary')
                    ->orderByPivot('sort_order')
                    ->orderByPivotDesc('intensity'),
            ])
            ->where(fn (Builder $query) => $this->publicPerfumes($query))
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhereHas('brand', fn (Builder $brandQuery) => $brandQuery->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($category, fn (Builder $query, string $slug) => $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $slug)))
            ->when($brand, fn (Builder $query, string $slug) => $query->whereHas('brand', fn (Builder $brandQuery) => $brandQuery->where('slug', $slug)))
            ->ordered()
            ->paginate(6)
            ->appends($request->query());

        $this->limitAccords($perfumes);

        return view('public.catalog', [
            'activeRoute' => 'catalog',
            'categories' => $categories,
            'brands' => $brands,
            'perfumes' => $perfumes,
            'search' => $search,
            'category' => $category,
            'brand' => $brand,
            'hasCriteria' => $search !== '' || $category !== null || $brand !== null,
        ]);
    }

    private function publicPerfumes(Builder $query): void
    {
        $query->active()
            ->whereHas('brand', fn (Builder $brandQuery) => $brandQuery->where('is_active', true))
            ->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->active());
    }

    private function validFilter(mixed $value, $options): ?string
    {
        $value = is_string($value) ? $value : null;

        return $options->contains('slug', $value) ? $value : null;
    }

    private function limitAccords(LengthAwarePaginator $perfumes): void
    {
        $perfumes->getCollection()->each(function (Perfume $perfume): void {
            $perfume->setRelation('accords', $perfume->accords->take(3));
        });
    }
}
