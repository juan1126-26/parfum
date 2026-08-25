<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNoteRequest;
use App\Http\Requests\Admin\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $notes = Note::query()
            ->withCount('perfumes')
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.notes.index', [
            'title' => 'Notas Olfativas',
            'breadcrumbs' => [['label' => 'Notas Olfativas']],
            'notes' => $notes,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.notes.create', $this->formData(new Note(['sort_order' => 0])));
    }

    public function store(StoreNoteRequest $request): RedirectResponse
    {
        Note::query()->create($request->validated());

        return to_route('admin.notes.index')->with('success', 'La nota olfativa fue creada.');
    }

    public function edit(Note $note): View
    {
        return view('admin.notes.edit', $this->formData($note));
    }

    public function update(UpdateNoteRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return to_route('admin.notes.edit', $note)->with('success', 'Los cambios de la nota fueron guardados.');
    }

    public function toggle(Note $note): RedirectResponse
    {
        $note->update(['is_active' => ! $note->is_active]);

        return back()->with('success', $note->is_active ? 'La nota esta activa nuevamente.' : 'La nota fue desactivada.');
    }

    private function formData(Note $note): array
    {
        return [
            'title' => $note->exists ? 'Editar nota olfativa' : 'Nueva nota olfativa',
            'breadcrumbs' => [
                ['label' => 'Notas Olfativas', 'route' => 'admin.notes.index'],
                ['label' => $note->exists ? 'Editar nota olfativa' : 'Nueva nota olfativa'],
            ],
            'note' => $note,
        ];
    }
}
