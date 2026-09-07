<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::query()->active()->ordered()->get();

        $featuredPerfumes = Perfume::query()
            ->active()
            ->where(function (Builder $query): void {
                $query->featured()->orWhere('is_best_seller', true);
            })
            ->with(['brand', 'category', 'coverImage'])
            ->ordered()
            ->limit(4)
            ->get();

        $accords = Perfume::query()
            ->active()
            ->featured()
            ->with(['accords' => fn ($query) => $query->active()->ordered()])
            ->ordered()
            ->first()
            ?->accords;

        return view('public.home', [
            'activeRoute' => 'home',
            'categories' => $categories,
            'featuredPerfumes' => $featuredPerfumes,
            'accords' => $accords ?? collect(),
            'title' => null,
            'description' => config('parfum.brand.description'),
            'canonical' => route('home'),
        ]);
    }
}
