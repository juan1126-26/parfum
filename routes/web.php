<?php

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
