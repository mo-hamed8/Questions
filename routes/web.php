<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view("questions","questions.index")->name("questions.index");
Route::view("questions/create","questions.create")->name("questions.create");

Route::view("selectFilters","filters")->name("selectFilters");

Route::view("questionByFilter/{categories}","questions.questionsByFilter")->name("questionByFilter");
Route::view("wrongQuestionsToday","questions.wrongQuestionsToday")->name("wrongQuestionsToday");

Route::view('home', 'home');


require __DIR__.'/auth.php';
