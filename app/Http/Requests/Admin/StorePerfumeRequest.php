<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StorePerfumeRequest extends PerfumeFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('perfumes', 'slug');
    }
}
