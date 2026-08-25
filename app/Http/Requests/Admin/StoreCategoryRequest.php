<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreCategoryRequest extends CategoryFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('categories', 'slug');
    }
}
