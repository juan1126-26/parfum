<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $brands = Brand::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query
                ->where(fn (Builder $query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.brands.index', [
            'title' => 'Marcas',
            'breadcrumbs' => [['label' => 'Marcas']],
            'brands' => $brands,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.brands.create', $this->formData(new Brand(['sort_order' => 0])));
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        Brand::query()->create($request->validated());

        return to_route('admin.brands.index')->with('success', 'La marca fue creada.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', $this->formData($brand));
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return to_route('admin.brands.edit', $brand)->with('success', 'Los cambios de la marca fueron guardados.');
    }

    public function toggle(Brand $brand): RedirectResponse
    {
        $brand->update(['is_active' => ! $brand->is_active]);

        return back()->with('success', $brand->is_active ? 'La marca esta activa nuevamente.' : 'La marca fue desactivada.');
    }

    private function formData(Brand $brand): array
    {
        return [
            'title' => $brand->exists ? 'Editar marca' : 'Nueva marca',
            'breadcrumbs' => [
                ['label' => 'Marcas', 'route' => 'admin.brands.index'],
                ['label' => $brand->exists ? 'Editar marca' : 'Nueva marca'],
            ],
            'brand' => $brand,
        ];
    }
}
