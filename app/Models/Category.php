<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function perfumes(): HasMany
    {
        return $this->hasMany(Perfume::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    public function getToneAttribute(): string
    {
        return match ($this->slug) {
            'perfumeria-arabe' => 'nocturne',
            'perfumeria-de-disenador' => 'light',
            'perfumeria-nicho' => 'mineral',
            'ediciones-especiales' => 'amber',
            default => 'signature',
        };
    }
}
