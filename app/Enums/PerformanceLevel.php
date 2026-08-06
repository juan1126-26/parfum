<?php

namespace App\Enums;

enum PerformanceLevel: string
{
    case Soft = 'soft';
    case Moderate = 'moderate';
    case Intense = 'intense';

    public function label(): string
    {
        return match ($this) {
            self::Soft => 'Suave',
            self::Moderate => 'Moderada',
            self::Intense => 'Intensa',
        };
    }
}
