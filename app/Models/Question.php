<?php

namespace App\Models;

use App\Enums\RecommendationCriterion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = ['text', 'description', 'criterion', 'is_required', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['criterion' => RecommendationCriterion::class, 'is_required' => 'boolean', 'is_active' => 'boolean'];
    }

    public function options(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }
}
