<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

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
}
