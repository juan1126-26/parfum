<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreNoteRequest extends NoteFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('notes', 'slug');
    }
}
