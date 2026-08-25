<?php

use App\Http\Controllers\Admin\AccordController as AdminAccordController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ClimateController as AdminClimateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\OccasionController as AdminOccasionController;
use App\Http\Controllers\Admin\PerfumeController as AdminPerfumeController;
use App\Http\Controllers\Admin\SeasonController as AdminSeasonController;
use App\Http\Controllers\Admin\UpcomingModuleController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\CompareController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InstitutionalController;
use App\Http\Controllers\Public\PerfectAromaController;
use App\Http\Controllers\Public\PerfumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('catalogo', CatalogController::class)->name('catalog');
Route::get('catalogo/{perfume}', PerfumeController::class)->name('catalog.show');
Route::get('comparador', CompareController::class)->name('comparator');
Route::get('mi-aroma-perfecto', [PerfectAromaController::class, 'index'])->name('perfect-aroma');
Route::post('mi-aroma-perfecto/resultados', [PerfectAromaController::class, 'results'])->name('perfect-aroma.results');

Route::get('nosotros', [InstitutionalController::class, 'about'])->name('about');
Route::get('contacto', [InstitutionalController::class, 'contact'])->name('contact');
Route::get('sitemap.xml', function () {
    return response()
        ->view('sitemap', ['urls' => config('parfum.seo.sitemap_routes')])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::prefix('admin')->as('admin.')->group(function (): void {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::middleware(['auth', 'admin', 'admin.no-cache'])->group(function (): void {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('perfumes', [AdminPerfumeController::class, 'index'])->name('perfumes.index');
        Route::get('perfumes/crear', [AdminPerfumeController::class, 'create'])->name('perfumes.create');
        Route::post('perfumes', [AdminPerfumeController::class, 'store'])->name('perfumes.store');
        Route::get('perfumes/{perfume:slug}/editar', [AdminPerfumeController::class, 'edit'])->name('perfumes.edit');
        Route::put('perfumes/{perfume:slug}', [AdminPerfumeController::class, 'update'])->name('perfumes.update');
        Route::patch('perfumes/{perfume:slug}/estado', [AdminPerfumeController::class, 'toggle'])->name('perfumes.toggle');
        Route::post('perfumes/{perfume:slug}/imagenes', [AdminPerfumeController::class, 'storeImage'])->name('perfumes.images.store');
        Route::put('perfumes/{perfume:slug}/imagenes/{image}', [AdminPerfumeController::class, 'updateImage'])->name('perfumes.images.update');
        Route::patch('perfumes/{perfume:slug}/imagenes/{image}/portada', [AdminPerfumeController::class, 'setCover'])->name('perfumes.images.cover');
        Route::delete('perfumes/{perfume:slug}/imagenes/{image}', [AdminPerfumeController::class, 'destroyImage'])->name('perfumes.images.destroy');
        Route::get('marcas', [AdminBrandController::class, 'index'])->name('brands.index');
        Route::get('marcas/crear', [AdminBrandController::class, 'create'])->name('brands.create');
        Route::post('marcas', [AdminBrandController::class, 'store'])->name('brands.store');
        Route::get('marcas/{brand:slug}/editar', [AdminBrandController::class, 'edit'])->name('brands.edit');
        Route::put('marcas/{brand:slug}', [AdminBrandController::class, 'update'])->name('brands.update');
        Route::patch('marcas/{brand:slug}/estado', [AdminBrandController::class, 'toggle'])->name('brands.toggle');
        Route::get('categorias', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('categorias/crear', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('categorias', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('categorias/{category:slug}/editar', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categorias/{category:slug}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::patch('categorias/{category:slug}/estado', [AdminCategoryController::class, 'toggle'])->name('categories.toggle');
        Route::get('acordes', [AdminAccordController::class, 'index'])->name('accords.index');
        Route::get('acordes/crear', [AdminAccordController::class, 'create'])->name('accords.create');
        Route::post('acordes', [AdminAccordController::class, 'store'])->name('accords.store');
        Route::get('acordes/{accord:slug}/editar', [AdminAccordController::class, 'edit'])->name('accords.edit');
        Route::put('acordes/{accord:slug}', [AdminAccordController::class, 'update'])->name('accords.update');
        Route::patch('acordes/{accord:slug}/estado', [AdminAccordController::class, 'toggle'])->name('accords.toggle');
        Route::get('notas', [AdminNoteController::class, 'index'])->name('notes.index');
        Route::get('notas/crear', [AdminNoteController::class, 'create'])->name('notes.create');
        Route::post('notas', [AdminNoteController::class, 'store'])->name('notes.store');
        Route::get('notas/{note:slug}/editar', [AdminNoteController::class, 'edit'])->name('notes.edit');
        Route::put('notas/{note:slug}', [AdminNoteController::class, 'update'])->name('notes.update');
        Route::patch('notas/{note:slug}/estado', [AdminNoteController::class, 'toggle'])->name('notes.toggle');
        Route::get('climas', [AdminClimateController::class, 'index'])->name('climates.index');
        Route::get('climas/crear', [AdminClimateController::class, 'create'])->name('climates.create');
        Route::post('climas', [AdminClimateController::class, 'store'])->name('climates.store');
        Route::get('climas/{climate:slug}/editar', [AdminClimateController::class, 'edit'])->name('climates.edit');
        Route::put('climas/{climate:slug}', [AdminClimateController::class, 'update'])->name('climates.update');
        Route::patch('climas/{climate:slug}/estado', [AdminClimateController::class, 'toggle'])->name('climates.toggle');
        Route::get('temporadas', [AdminSeasonController::class, 'index'])->name('seasons.index');
        Route::get('temporadas/crear', [AdminSeasonController::class, 'create'])->name('seasons.create');
        Route::post('temporadas', [AdminSeasonController::class, 'store'])->name('seasons.store');
        Route::get('temporadas/{season:slug}/editar', [AdminSeasonController::class, 'edit'])->name('seasons.edit');
        Route::put('temporadas/{season:slug}', [AdminSeasonController::class, 'update'])->name('seasons.update');
        Route::patch('temporadas/{season:slug}/estado', [AdminSeasonController::class, 'toggle'])->name('seasons.toggle');
        Route::get('ocasiones', [AdminOccasionController::class, 'index'])->name('occasions.index');
        Route::get('ocasiones/crear', [AdminOccasionController::class, 'create'])->name('occasions.create');
        Route::post('ocasiones', [AdminOccasionController::class, 'store'])->name('occasions.store');
        Route::get('ocasiones/{occasion:slug}/editar', [AdminOccasionController::class, 'edit'])->name('occasions.edit');
        Route::put('ocasiones/{occasion:slug}', [AdminOccasionController::class, 'update'])->name('occasions.update');
        Route::patch('ocasiones/{occasion:slug}/estado', [AdminOccasionController::class, 'toggle'])->name('occasions.toggle');
        Route::get('{module}', UpcomingModuleController::class)->name('upcoming');
    });
});
