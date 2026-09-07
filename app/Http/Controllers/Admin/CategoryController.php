<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\AdminCategoryImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $categories = Category::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query
                ->where(fn (Builder $query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.categories.index', [
            'title' => 'Categorias',
            'breadcrumbs' => [['label' => 'Categorias']],
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', $this->formData(new Category(['sort_order' => 0])));
    }

    public function store(StoreCategoryRequest $request, AdminCategoryImageService $imageService): RedirectResponse
    {
        $data = $request->validated();
        unset($data['cover_image']);
        $coverImage = null;

        if ($request->hasFile('cover_image')) {
            $coverImage = $imageService->store($request->file('cover_image'));
            $data['cover_image'] = $coverImage;
        }

        try {
            Category::query()->create($data);
        } catch (\Throwable $exception) {
            $imageService->delete($coverImage);

            throw $exception;
        }

        return to_route('admin.categories.index')->with('success', 'La categoria fue creada.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', $this->formData($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category, AdminCategoryImageService $imageService): RedirectResponse
    {
        $data = $request->validated();
        unset($data['cover_image']);
        $newCoverImage = null;
        $previousCoverImage = $category->cover_image;

        if ($request->hasFile('cover_image')) {
            $newCoverImage = $imageService->store($request->file('cover_image'));
            $data['cover_image'] = $newCoverImage;
        }

        try {
            $category->update($data);
        } catch (\Throwable $exception) {
            $imageService->delete($newCoverImage);

            throw $exception;
        }

        if ($newCoverImage !== null) {
            $imageService->delete($previousCoverImage);
        }

        return to_route('admin.categories.edit', $category)->with('success', 'Los cambios de la categoria fueron guardados.');
    }

    public function toggle(Category $category): RedirectResponse
    {
        $category->update(['is_active' => ! $category->is_active]);

        return back()->with('success', $category->is_active ? 'La categoria esta activa nuevamente.' : 'La categoria fue desactivada.');
    }

    private function formData(Category $category): array
    {
        return [
            'title' => $category->exists ? 'Editar categoria' : 'Nueva categoria',
            'breadcrumbs' => [
                ['label' => 'Categorias', 'route' => 'admin.categories.index'],
                ['label' => $category->exists ? 'Editar categoria' : 'Nueva categoria'],
            ],
            'category' => $category,
        ];
    }
}
