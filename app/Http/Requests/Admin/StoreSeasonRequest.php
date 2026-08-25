<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreSeasonRequest extends SeasonFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('seasons', 'slug');
    }
}
