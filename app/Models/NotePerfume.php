<?php

namespace App\Models;

use App\Enums\OlfactoryStage;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NotePerfume extends Pivot
{
    protected $table = 'note_perfume';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'stage' => OlfactoryStage::class,
            'sort_order' => 'integer',
        ];
    }
}
