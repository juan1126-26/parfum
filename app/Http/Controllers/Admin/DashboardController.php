<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Note;
use App\Models\Perfume;
use App\Models\Question;
use App\Models\RecommendationRule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'breadcrumbs' => [['label' => 'Dashboard']],
            'metrics' => [
                ['label' => 'Perfumes', 'value' => Perfume::query()->count(), 'detail' => 'Fragancias registradas'],
                ['label' => 'Marcas', 'value' => Brand::query()->count(), 'detail' => 'Casas y estudios'],
                ['label' => 'Categorias', 'value' => Category::query()->count(), 'detail' => 'Colecciones disponibles'],
                ['label' => 'Acordes', 'value' => Accord::query()->count(), 'detail' => 'Perfiles olfativos'],
                ['label' => 'Notas', 'value' => Note::query()->count(), 'detail' => 'Materias y notas'],
                ['label' => 'Preguntas', 'value' => Question::query()->count(), 'detail' => 'Mi Aroma Perfecto'],
                ['label' => 'Reglas', 'value' => RecommendationRule::query()->count(), 'detail' => 'Afinidades configuradas'],
            ],
        ]);
    }
}
