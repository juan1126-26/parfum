<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreClimateRequest extends ClimateFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('climates', 'slug');
    }
}
