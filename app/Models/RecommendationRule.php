<?php
namespace App\Models;
use App\Enums\RecommendationCriterion; use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RecommendationRule extends Model { protected $fillable=['answer_option_id','criterion','target_id','target_value','weight','is_active']; protected function casts():array{return ['criterion'=>RecommendationCriterion::class,'is_active'=>'boolean'];} public function answerOption():BelongsTo{return $this->belongsTo(AnswerOption::class);} }
