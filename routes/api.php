<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EvaluationController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('users', [UserController::class, 'index']);
Route::get('user/{id}', [UserController::class, 'show']);
//courses de un usuario
Route::get('user/{id}/courses', [UserController::class, 'showUserCourses']);
//Evaluations de un usuario
Route::get('user/{id}/evaluations', [UserController::class, 'showUserEvaluations']);
Route::post('admin', [UserController::class, 'createAdmin']);
Route::post('user', [UserController::class, 'store']);
Route::delete('user/{id}', [UserController::class, 'destroy']);
Route::put('user/{id}', [UserController::class, 'update']);


Route::get('categories', [CategoryController::class, 'index']);
Route::get('category/{id}', [CategoryController::class, 'show']);
//courses por categoria
Route::get('category/{id}/courses', [CategoryController::class, 'coursesPorCategory']);
Route::post('category', [CategoryController::class, 'store']);
Route::put('category/{id}', [CategoryController::class, 'update']);
Route::delete('category/{id}', [CategoryController::class, 'destroy']);



Route::get('courses', [CourseController::class, 'index']);
Route::get('course/{id}', [CourseController::class, 'show']);
Route::post('course', [CourseController::class, 'store']);
Route::put('course/{id}', [CourseController::class, 'update']);
Route::delete('course/{id}', [CourseController::class, 'destroy']);


Route::get('enrollments', [EnrollmentController::class, 'index']);
Route::post('enrollment', [EnrollmentController::class, 'store']);
Route::get('enrollment/{id}', [EnrollmentController::class, 'show']);
Route::delete('enrollment/{id}', [EnrollmentController::class, 'destroy']);
Route::put('enrollment/{id}', [EnrollmentController::class, 'update']);

Route::get('evaluations', [EvaluationController::class, 'index']);
Route::get('evaluation/{id}', [EvaluationController::class, 'show']);
Route::post('evaluation', [EvaluationController::class, 'store']);
Route::delete('evaluation/{id}', [EvaluationController::class, 'destroy']);
Route::put('evaluation/{id}', [EvaluationController::class, 'edit']);



