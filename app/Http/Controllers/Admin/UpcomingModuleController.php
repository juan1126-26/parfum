<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UpcomingModuleController extends Controller
{
    public function __invoke(string $module): View
    {
        /** @var array{key: string, label: string, route?: string}|null $item */
        $item = collect(config('parfum.admin.navigation'))
            ->first(fn (array $item): bool => $item['key'] === $module && ! isset($item['route']));

        abort_unless($item, 404);

        return view('admin.upcoming', [
            'title' => $item['label'],
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                ['label' => $item['label']],
            ],
            'module' => $item,
        ]);
    }
}
