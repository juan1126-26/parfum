<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClimateRequest;
use App\Http\Requests\Admin\UpdateClimateRequest;
use App\Models\Climate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClimateController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $climates = Climate::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.climates.index', [
            'title' => 'Climas',
            'breadcrumbs' => [['label' => 'Climas']],
            'climates' => $climates,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.climates.create', $this->formData(new Climate(['sort_order' => 0])));
    }

    public function store(StoreClimateRequest $request): RedirectResponse
    {
        Climate::query()->create($request->validated());

        return to_route('admin.climates.index')->with('success', 'El clima fue creado.');
    }

    public function edit(Climate $climate): View
    {
        return view('admin.climates.edit', $this->formData($climate));
    }

    public function update(UpdateClimateRequest $request, Climate $climate): RedirectResponse
    {
        $climate->update($request->validated());

        return to_route('admin.climates.edit', $climate)->with('success', 'Los cambios del clima fueron guardados.');
    }

    public function toggle(Climate $climate): RedirectResponse
    {
        $climate->update(['is_active' => ! $climate->is_active]);

        return back()->with('success', $climate->is_active ? 'El clima esta activo nuevamente.' : 'El clima fue desactivado.');
    }

    private function formData(Climate $climate): array
    {
        return [
            'title' => $climate->exists ? 'Editar clima' : 'Nuevo clima',
            'breadcrumbs' => [
                ['label' => 'Climas', 'route' => 'admin.climates.index'],
                ['label' => $climate->exists ? 'Editar clima' : 'Nuevo clima'],
            ],
            'climate' => $climate,
        ];
    }
}
