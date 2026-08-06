<?php

namespace App\Models;

use App\Enums\PerformanceLevel;
use Database\Factories\PerfumeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perfume extends Model
{
    /** @use HasFactory<PerfumeFactory> */
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'editorial_story',
        'longevity_level',
        'projection_level',
        'intensity_level',
        'image',
        'is_featured',
        'is_best_seller',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_active' => 'boolean',
            'longevity_level' => PerformanceLevel::class,
            'projection_level' => PerformanceLevel::class,
            'intensity_level' => PerformanceLevel::class,
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function accords(): BelongsToMany
    {
        return $this->belongsToMany(Accord::class)
            ->using(AccordPerfume::class)
            ->withPivot(['intensity', 'sort_order', 'is_primary'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class)
            ->using(NotePerfume::class)
            ->withPivot(['stage', 'sort_order'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function climates(): BelongsToMany
    {
        return $this->belongsToMany(Climate::class)->withTimestamps();
    }

    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class)->withTimestamps();
    }

    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class)->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(PerfumeImage::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopeBestSeller(Builder $query): void
    {
        $query->where('is_best_seller', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    public function getToneAttribute(): string
    {
        return match ($this->category?->slug) {
            'perfumeria-de-disenador' => 'forest',
            'perfumeria-nicho' => 'mineral',
            'seleccion-parfum' => 'nocturne',
            default => 'amber',
        };
    }
}
