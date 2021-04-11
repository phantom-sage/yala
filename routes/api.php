<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::post('teachers/create-new-quiz', [TeacherController::class, 'create_new_quiz']);
Route::resource('lessons', LessonController::class);
Route::put('lessons/add-quiz-to-lesson/{id}', [LessonController::class, 'add_quiz_to_lesson']);
