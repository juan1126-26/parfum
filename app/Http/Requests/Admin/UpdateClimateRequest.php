<?php

namespace App\Http\Requests\Admin;

use App\Models\Climate;
use Illuminate\Validation\Rule;

class UpdateClimateRequest extends ClimateFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Climate $climate */
        $climate = $this->route('climate');

        return Rule::unique('climates', 'slug')->ignore($climate);
    }
}
