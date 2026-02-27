<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    //
    public function questionByFilter($categories)
    {
        $categoriesArray = explode(',', $categories);

        $questions = Question::with('categories')
            ->whereHas('categories', function ($q) use ($categoriesArray) {
                $q->whereIn('name', $categoriesArray);
            })
            ->get();

        $questions = $questions->shuffle(); // ↩️ ترتيب عشوائي

        return response()->json($questions);
    }

    public function wrongQuestionsToday(){
    $questions = Question::whereHas('answers', function ($query) {
        $query->where('user_id', env('DEFULT_USER_ID'))
              ->where('isCorrect', false)
              ->whereDate('created_at', today());
    })->get();

    $questions = $questions->shuffle();

    return response()->json($questions);
}

}
