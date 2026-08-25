<?php

namespace App\Http\Requests\Admin;

use App\Models\Note;
use Illuminate\Validation\Rule;

class UpdateNoteRequest extends NoteFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Note $note */
        $note = $this->route('note');

        return Rule::unique('notes', 'slug')->ignore($note);
    }
}
