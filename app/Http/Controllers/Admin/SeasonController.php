<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSeasonRequest;
use App\Http\Requests\Admin\UpdateSeasonRequest;
use App\Models\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeasonController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $seasons = Season::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.seasons.index', [
            'title' => 'Temporadas',
            'breadcrumbs' => [['label' => 'Temporadas']],
            'seasons' => $seasons,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.seasons.create', $this->formData(new Season(['sort_order' => 0])));
    }

    public function store(StoreSeasonRequest $request): RedirectResponse
    {
        Season::query()->create($request->validated());

        return to_route('admin.seasons.index')->with('success', 'La temporada fue creada.');
    }

    public function edit(Season $season): View
    {
        return view('admin.seasons.edit', $this->formData($season));
    }

    public function update(UpdateSeasonRequest $request, Season $season): RedirectResponse
    {
        $season->update($request->validated());

        return to_route('admin.seasons.edit', $season)->with('success', 'Los cambios de la temporada fueron guardados.');
    }

    public function toggle(Season $season): RedirectResponse
    {
        $season->update(['is_active' => ! $season->is_active]);

        return back()->with('success', $season->is_active ? 'La temporada esta activa nuevamente.' : 'La temporada fue desactivada.');
    }

    private function formData(Season $season): array
    {
        return [
            'title' => $season->exists ? 'Editar temporada' : 'Nueva temporada',
            'breadcrumbs' => [
                ['label' => 'Temporadas', 'route' => 'admin.seasons.index'],
                ['label' => $season->exists ? 'Editar temporada' : 'Nueva temporada'],
            ],
            'season' => $season,
        ];
    }
}
