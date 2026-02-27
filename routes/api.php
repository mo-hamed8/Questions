<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\FilterController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("questions",[QuestionController::class,"index"]);
Route::post("questions",[QuestionController::class,"store"]);
Route::post("answer",[QuestionController::class,"answer"]);

Route::get("categories",[CategoryController::class,"index"]);

Route::get("questionByFilter/{categories}",[FilterController::class,"questionByFilter"]);
Route::get("wrongQuestionsToday",[FilterController::class,"wrongQuestionsToday"]);
