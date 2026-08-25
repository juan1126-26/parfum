<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOccasionRequest;
use App\Http\Requests\Admin\UpdateOccasionRequest;
use App\Models\Occasion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OccasionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $occasions = Occasion::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.occasions.index', [
            'title' => 'Ocasiones',
            'breadcrumbs' => [['label' => 'Ocasiones']],
            'occasions' => $occasions,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.occasions.create', $this->formData(new Occasion(['sort_order' => 0])));
    }

    public function store(StoreOccasionRequest $request): RedirectResponse
    {
        Occasion::query()->create($request->validated());

        return to_route('admin.occasions.index')->with('success', 'La ocasion fue creada.');
    }

    public function edit(Occasion $occasion): View
    {
        return view('admin.occasions.edit', $this->formData($occasion));
    }

    public function update(UpdateOccasionRequest $request, Occasion $occasion): RedirectResponse
    {
        $occasion->update($request->validated());

        return to_route('admin.occasions.edit', $occasion)->with('success', 'Los cambios de la ocasion fueron guardados.');
    }

    public function toggle(Occasion $occasion): RedirectResponse
    {
        $occasion->update(['is_active' => ! $occasion->is_active]);

        return back()->with('success', $occasion->is_active ? 'La ocasion esta activa nuevamente.' : 'La ocasion fue desactivada.');
    }

    private function formData(Occasion $occasion): array
    {
        return [
            'title' => $occasion->exists ? 'Editar ocasion' : 'Nueva ocasion',
            'breadcrumbs' => [
                ['label' => 'Ocasiones', 'route' => 'admin.occasions.index'],
                ['label' => $occasion->exists ? 'Editar ocasion' : 'Nueva ocasion'],
            ],
            'occasion' => $occasion,
        ];
    }
}
