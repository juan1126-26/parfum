<?php

namespace App\Enums;

enum OlfactoryStage: string
{
    case Top = 'top';
    case Heart = 'heart';
    case Base = 'base';

    public function label(): string
    {
        return match ($this) {
            self::Top => 'Salida',
            self::Heart => 'Corazon',
            self::Base => 'Fondo',
        };
    }
}
