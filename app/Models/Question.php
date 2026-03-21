<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    //
    protected $fillable = [
    'title',
    'choiceA',
    'choiceB',
    'choiceC',
    'choiceD',
    'answer',
];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function answers():HasMany{
        return $this->hasMany(Answer::class);
    }

    public function explanation():HasOne{
        return $this->hasOne(Explanation::class);
    }
}
