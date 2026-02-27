<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    //
    protected $fillable = [
        'user_id',
        'question_id',
        'selectedChoice',
        'isCorrect',
    ];

    public function question():BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
