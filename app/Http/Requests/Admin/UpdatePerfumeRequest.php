<?php

namespace App\Http\Requests\Admin;

use App\Models\Perfume;
use Illuminate\Validation\Rule;

class UpdatePerfumeRequest extends PerfumeFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Perfume $perfume */
        $perfume = $this->route('perfume');

        return Rule::unique('perfumes', 'slug')->ignore($perfume);
    }
}
