<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PerformanceLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePerfumeImageRequest;
use App\Http\Requests\Admin\StorePerfumeRequest;
use App\Http\Requests\Admin\UpdatePerfumeImageRequest;
use App\Http\Requests\Admin\UpdatePerfumeRequest;
use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Climate;
use App\Models\Note;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\PerfumeImage;
use App\Models\Season;
use App\Services\AdminPerfumeImageService;
use App\Services\AdminPerfumeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfumeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $status = $request->string('status')->toString();
        $sort = $this->sort($request->string('sort')->toString());
        $direction = $request->string('direction')->lower()->toString() === 'desc' ? 'desc' : 'asc';

        $perfumes = Perfume::query()
            ->with(['brand:id,name', 'category:id,name'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhereHas('brand', fn (Builder $brand) => $brand->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('category', fn (Builder $category) => $category->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($status === 'active', fn (Builder $query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn (Builder $query) => $query->where('is_active', false));

        $this->applySort($perfumes, $sort, $direction);

        return view('admin.perfumes.index', [
            'title' => 'Perfumes',
            'breadcrumbs' => [['label' => 'Perfumes']],
            'perfumes' => $perfumes->paginate(12)->withQueryString(),
            'filters' => compact('search', 'status', 'sort', 'direction'),
        ]);
    }

    public function create(): View
    {
        return view('admin.perfumes.create', $this->formViewData(new Perfume([
            'is_featured' => false,
            'is_best_seller' => false,
            'sort_order' => 0,
        ])));
    }

    public function store(StorePerfumeRequest $request, AdminPerfumeService $service): RedirectResponse
    {
        $perfume = $service->create($request->validated());

        return to_route('admin.perfumes.index')
            ->with('success', 'El perfume fue creado y sus relaciones fueron sincronizadas.');
    }

    public function edit(Perfume $perfume): View
    {
        $perfume->load(['accords', 'notes', 'climates', 'seasons', 'occasions', 'images']);

        return view('admin.perfumes.edit', $this->formViewData($perfume));
    }

    public function update(UpdatePerfumeRequest $request, Perfume $perfume, AdminPerfumeService $service): RedirectResponse
    {
        $service->update($perfume, $request->validated());

        return to_route('admin.perfumes.edit', $perfume)
            ->with('success', 'Los cambios del perfume fueron guardados.');
    }

    public function toggle(Perfume $perfume): RedirectResponse
    {
        $perfume->update(['is_active' => ! $perfume->is_active]);

        return back()->with('success', $perfume->is_active
            ? 'El perfume esta activo nuevamente.'
            : 'El perfume fue desactivado.');
    }

    public function storeImage(StorePerfumeImageRequest $request, Perfume $perfume, AdminPerfumeImageService $service): RedirectResponse
    {
        $service->store($perfume, $request->file('image'), $request->validated('alt_text'));

        return to_route('admin.perfumes.edit', $perfume)->with('success', 'La imagen fue incorporada al perfume.');
    }

    public function updateImage(UpdatePerfumeImageRequest $request, Perfume $perfume, PerfumeImage $image, AdminPerfumeImageService $service): RedirectResponse
    {
        $this->ensureImageBelongsToPerfume($perfume, $image);
        $service->update($image, $request->validated());

        return to_route('admin.perfumes.edit', $perfume)->with('success', 'Los detalles de la imagen fueron guardados.');
    }

    public function setCover(Perfume $perfume, PerfumeImage $image, AdminPerfumeImageService $service): RedirectResponse
    {
        $this->ensureImageBelongsToPerfume($perfume, $image);
        $service->setCover($perfume, $image);

        return to_route('admin.perfumes.edit', $perfume)->with('success', 'La imagen de portada fue actualizada.');
    }

    public function destroyImage(Perfume $perfume, PerfumeImage $image, AdminPerfumeImageService $service): RedirectResponse
    {
        $this->ensureImageBelongsToPerfume($perfume, $image);
        $service->delete($image);

        return to_route('admin.perfumes.edit', $perfume)->with('success', 'La imagen fue eliminada.');
    }

    private function formViewData(Perfume $perfume): array
    {
        return [
            'title' => $perfume->exists ? 'Editar perfume' : 'Nuevo perfume',
            'breadcrumbs' => [
                ['label' => 'Perfumes', 'route' => 'admin.perfumes.index'],
                ['label' => $perfume->exists ? 'Editar perfume' : 'Nuevo perfume'],
            ],
            'perfume' => $perfume,
            'brands' => Brand::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
            'categories' => Category::query()->active()->ordered()->get(['id', 'name']),
            'accords' => Accord::query()->active()->ordered()->get(['id', 'name']),
            'notes' => Note::query()->active()->ordered()->get(['id', 'name']),
            'climates' => Climate::query()->active()->ordered()->get(['id', 'name']),
            'seasons' => Season::query()->active()->ordered()->get(['id', 'name']),
            'occasions' => Occasion::query()->active()->ordered()->get(['id', 'name']),
            'performanceLevels' => PerformanceLevel::cases(),
        ];
    }

    private function ensureImageBelongsToPerfume(Perfume $perfume, PerfumeImage $image): void
    {
        abort_unless($image->perfume_id === $perfume->id, 404);
    }

    private function sort(string $sort): string
    {
        return in_array($sort, ['name', 'brand', 'category', 'status', 'sort_order'], true)
            ? $sort
            : 'sort_order';
    }

    private function applySort(Builder $query, string $sort, string $direction): void
    {
        match ($sort) {
            'brand' => $query->orderBy(
                Brand::query()->select('name')->whereColumn('brands.id', 'perfumes.brand_id'),
                $direction,
            ),
            'category' => $query->orderBy(
                Category::query()->select('name')->whereColumn('categories.id', 'perfumes.category_id'),
                $direction,
            ),
            'status' => $query->orderBy('is_active', $direction),
            default => $query->orderBy($sort, $direction),
        };

        if ($sort !== 'name') {
            $query->orderBy('name');
        }
    }
}
