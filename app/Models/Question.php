<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
