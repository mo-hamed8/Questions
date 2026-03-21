<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{


    public function index()
    {
        // جلب كل الأسئلة مع التصنيفات
        $questions = Question::with('categories')->get();

        // نعيد JSON مباشر
        return response()->json($questions, 200);
    }
    //


    public function store(Request $request)
    {
        $data = $request->validate([
            'categories' => 'array',
            'categories.*' => 'string',
            'questions' => 'required|array',
            'questions.*.title' => 'required|string',
            'questions.*.choiceA' => 'required|string',
            'questions.*.choiceB' => 'required|string',
            'questions.*.choiceC' => 'required|string',
            'questions.*.choiceD' => 'required|string',
            'questions.*.answer' => 'required|string',
        ]);

        // إنشاء أو استدعاء التصنيفات
        $categoryIds = [];
        foreach ($data['categories'] as $catName) {
            $category = Category::firstOrCreate(['name' => $catName]);
            $categoryIds[] = $category->id;
        }

        // إنشاء الأسئلة وربطها بالتصنيفات
        foreach ($data['questions'] as $qData) {
            $question = Question::create($qData);
            $question->categories()->attach($categoryIds);
        }

        return response()->json(['message' => 'Questions saved with categories']);
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
            "user_id" => env('DEFULT_USER_ID'),
            "question_id" => $question->id,
            "selectedChoice" => $request["choice"],
            "isCorrect" => $isCorrect
        ]);

        return response()->json([
            "message" => "Answer saved",
            "isCorrect" => $isCorrect
        ], 200);
    }

    public function getExplanation(Question $q, $save = False, OpenAIService $explanation)
    {

        if ($q->answer == "A") {
            $answer = $q->choiceA;
        } elseif ($q->answer == "B") {
            $answer = $q->choiceB;
        } elseif ($q->answer == "C") {
            $answer = $q->choiceC;
        } else {
            $answer = $q->choiceD;
        }

        $qFormat = [
            "question" => $q->title,
            "answer" => $answer
        ];

        $response = $explanation->chat($qFormat);

        if ($save) {
            $this->saveExplanation($q, $response);
        }

        return $response;
    }

    private function saveExplanation(Question $q, $response)
    {
        $q->explanation()->create([
            'rule_name' => 'Present Continuous',
            'grammar_topic' => 'Verb Tenses',
            'tags' => ['present continuous', 'tense'],
            'reason' => 'The action is happening now',
            'detailed_explanation' => 'We use present continuous for ongoing actions...',
            'arabic_explanation' => 'نستخدم المضارع المستمر للأفعال الجارية الآن',
            'confidence' => 0.95
        ]);
        return 0;
    }
}
