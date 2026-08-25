<?php

namespace App\Http\Requests\Admin;

use App\Models\Season;
use Illuminate\Validation\Rule;

class UpdateSeasonRequest extends SeasonFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Season $season */
        $season = $this->route('season');

        return Rule::unique('seasons', 'slug')->ignore($season);
    }
}
