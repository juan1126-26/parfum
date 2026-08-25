<?php

namespace App\Http\Requests\Admin;

use App\Models\Occasion;
use Illuminate\Validation\Rule;

class UpdateOccasionRequest extends OccasionFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Occasion $occasion */
        $occasion = $this->route('occasion');

        return Rule::unique('occasions', 'slug')->ignore($occasion);
    }
}
