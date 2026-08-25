<?php

namespace App\Http\Requests\Admin;

use App\Models\Accord;
use Illuminate\Validation\Rule;

class UpdateAccordRequest extends AccordFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Accord $accord */
        $accord = $this->route('accord');

        return Rule::unique('accords', 'slug')->ignore($accord);
    }
}
