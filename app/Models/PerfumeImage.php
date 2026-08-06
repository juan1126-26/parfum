<?php

namespace App\Models;

use Database\Factories\PerfumeImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfumeImage extends Model
{
    /** @use HasFactory<PerfumeImageFactory> */
    use HasFactory;

    protected $fillable = ['perfume_id', 'path', 'alt_text', 'is_cover', 'sort_order'];

    protected function casts(): array
    {
        return ['is_cover' => 'boolean'];
    }

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }
}
