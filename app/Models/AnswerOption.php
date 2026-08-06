<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo; use Illuminate\Database\Eloquent\Relations\HasMany;
class AnswerOption extends Model { protected $fillable=['question_id','label','description','value','is_active','sort_order']; public function question():BelongsTo{return $this->belongsTo(Question::class);} public function rules():HasMany{return $this->hasMany(RecommendationRule::class);} }
