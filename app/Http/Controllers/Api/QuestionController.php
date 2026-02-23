<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{


    public function index()
    {
        return response()->json(Question::all(), 200);
    }
    //


    public function store(Request $request)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.title' => 'required|string',
            'questions.*.choiceA' => 'required|string',
            'questions.*.choiceB' => 'required|string',
            'questions.*.choiceC' => 'required|string',
            'questions.*.choiceD' => 'required|string',
            'questions.*.answer' => 'required|string|in:A,B,C,D',
        ]);

        $questions = Question::insert($validated['questions']);

        return response()->json([
            'message' => 'Questions stored successfully',
        ], 201);
    }


    public function answer(Request $request)
    {
        // choices 0->A  1->B  2->C 3->D

        $request->validate([
            "question_id" => "required|exists:questions,id",
            "choice" => "required"
        ]);

        $question = Question::findOrFail($request["question_id"]);
        $isCorrect = strtolower($request["choice"]) === strtolower($question->answer);

        Answer::create([
            "user_id" => "1",
            "question_id" => $question->id,
            "selectedChoice" => $request["choice"],
            "isCorrect" => $isCorrect
        ]);

        return response()->json([
            "message" => "Answer saved",
            "isCorrect" => $isCorrect
        ], 200);
    }
}
