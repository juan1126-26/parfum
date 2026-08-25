<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreOccasionRequest extends OccasionFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('occasions', 'slug');
    }
}
