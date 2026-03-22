<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Explanation extends Model
{
    //
    protected $casts = [
    'tags' => 'array',
];
    protected $fillable = [
    'question_id',
    'rule_name',
    'grammar_topic',
    'tags',
    'reason',
    'detailed_explanation',
    'arabic_explanation',
    'confidence',
];


    public function question():BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
