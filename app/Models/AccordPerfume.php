<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AccordPerfume extends Pivot
{
    protected $table = 'accord_perfume';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'intensity' => 'integer',
            'sort_order' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    public function getIntensityLabelAttribute(): string
    {
        return match (true) {
            $this->intensity >= 80 => 'Intensidad envolvente',
            $this->intensity >= 70 => 'Intensidad marcada',
            $this->intensity >= 55 => 'Intensidad cálida',
            $this->intensity >= 40 => 'Intensidad luminosa',
            default => 'Intensidad sutil',
        };
    }

    public function getMeterSegmentsAttribute(): int
    {
        return max(1, min(5, (int) ceil($this->intensity / 20)));
    }
}
