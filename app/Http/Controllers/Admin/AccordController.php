<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAccordRequest;
use App\Http\Requests\Admin\UpdateAccordRequest;
use App\Models\Accord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccordController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $accords = Accord::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.accords.index', [
            'title' => 'Acordes',
            'breadcrumbs' => [['label' => 'Acordes']],
            'accords' => $accords,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.accords.create', $this->formData(new Accord(['sort_order' => 0])));
    }

    public function store(StoreAccordRequest $request): RedirectResponse
    {
        Accord::query()->create($request->validated());

        return to_route('admin.accords.index')->with('success', 'El acorde fue creado.');
    }

    public function edit(Accord $accord): View
    {
        return view('admin.accords.edit', $this->formData($accord));
    }

    public function update(UpdateAccordRequest $request, Accord $accord): RedirectResponse
    {
        $accord->update($request->validated());

        return to_route('admin.accords.edit', $accord)->with('success', 'Los cambios del acorde fueron guardados.');
    }

    public function toggle(Accord $accord): RedirectResponse
    {
        $accord->update(['is_active' => ! $accord->is_active]);

        return back()->with('success', $accord->is_active ? 'El acorde esta activo nuevamente.' : 'El acorde fue desactivado.');
    }

    private function formData(Accord $accord): array
    {
        return [
            'title' => $accord->exists ? 'Editar acorde' : 'Nuevo acorde',
            'breadcrumbs' => [
                ['label' => 'Acordes', 'route' => 'admin.accords.index'],
                ['label' => $accord->exists ? 'Editar acorde' : 'Nuevo acorde'],
            ],
            'accord' => $accord,
        ];
    }
}
