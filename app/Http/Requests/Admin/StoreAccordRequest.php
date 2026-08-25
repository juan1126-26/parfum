<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreAccordRequest extends AccordFormRequest
{
    protected function slugRule(): mixed
    {
        return Rule::unique('accords', 'slug');
    }
}
