<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreBrandRequest extends BrandFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('brands', 'slug');
    }
}
