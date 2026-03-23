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

    public function getExplanationFromApi(Question $question, OpenAIService $explanation, $save = True)
    {

        if ($question->answer == "A") {
            $answer = $question->choiceA;
        } elseif ($question->answer == "B") {
            $answer = $question->choiceB;
        } elseif ($question->answer == "C") {
            $answer = $question->choiceC;
        } else {
            $answer = $question->choiceD;
        }

        $qFormat = [
            "question" => $question->title,
            "choiceA" => $question->choiceA,
            "choiceB" => $question->choiceB,
            "choiceC" => $question->choiceC,
            "choiceD" => $question->choiceD,
            "answer" => $answer
        ];


        $response = $explanation->chat($qFormat);

        if ($save) {
            $this->saveExplanation($question, $response);
        }

        return $response;
    }

    private function saveExplanation(Question $question, array $response)
    {
        $question->explanation()->create([
            'rule_name' => $response['rule_name'],
            'grammar_topic' => $response['grammar_topic'],
            'tags' => $response['tags'] ?? [],
            'reason' => $response['reason'],
            'detailed_explanation' => $response['detailed_explanation'],
            'arabic_explanation' => $response['arabic_explanation'],
            'confidence' => $response['confidence'],
        ]);
    }

    public function getExplanation(Question $question,OpenAIService $openAIService)
    {
        $exp = $question->explanation()->first();

if ($exp) {
    return $exp; // تم العثور على الشرح
} else {
    return $this->getExplanationFromApi($question, $openAIService);
}
    }
}
