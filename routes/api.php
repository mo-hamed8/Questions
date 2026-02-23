<?php

use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("questions",[QuestionController::class,"index"]);
Route::post("questions",[QuestionController::class,"store"]);
Route::post("answer",[QuestionController::class,"answer"]);
