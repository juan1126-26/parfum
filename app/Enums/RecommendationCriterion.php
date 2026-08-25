<?php

namespace App\Enums;

enum RecommendationCriterion: string
{
    case Occasion = 'occasion';
    case Climate = 'climate';
    case Accord = 'accord';
    case Duration = 'duration';
    case Projection = 'projection';
    case Intensity = 'intensity';

    public function label(): string
    {
        return match ($this) {
            self::Occasion => 'Ocasion',
            self::Climate => 'Clima',
            self::Accord => 'Acorde',
            self::Duration => 'Duracion',
            self::Projection => 'Proyeccion',
            self::Intensity => 'Intensidad',
        };
    }
}
