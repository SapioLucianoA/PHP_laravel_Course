<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\API\AuthController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//ROUTAS PUBLICAS
//LOGIN
Route::post('login', [AuthController::class, 'login']);
//registrar ususario:
Route::post('user', [UserController::class, 'store']);
//courses por categoria
Route::get('category/{id}/courses', [CategoryController::class, 'coursesPorCategory']);



    // Rutas protegidas por autenticación--------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    //authenticated user
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    //USERS

    Route::get('user/{id}', [UserController::class, 'show']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::get('users', [UserController::class, 'index']);
    //Evaluations de un usuario
    Route::get('user/{id}/evaluations', [UserController::class, 'showUserEvaluations']);
    //courses de un usuario
    Route::get('user/{id}/courses', [UserController::class, 'showUserCourses']);


    //CATEGORIES--------------------------------------
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);

    //COURSES--------------------------------------
    Route::get('courses', [CourseController::class, 'index']); // paginacion en 10
    Route::get('course/{id}', [CourseController::class, 'show']);

    //ENROLMENTS--------------------------------------
    Route::post('enrollment', [EnrollmentController::class, 'store']);
    Route::get('enrollment/{id}', [EnrollmentController::class, 'show']);
    Route::delete('enrollment/{id}', [EnrollmentController::class, 'destroy']);


    //EVALUATIONS--------------------------------------
        Route::get('evaluation/{id}', [EvaluationController::class, 'show']);
});


    // Rutas solo para administradores---------------------------------------------
Route::middleware(['auth:sanctum', 'admin'])->group(function () {


    //USERS ADMINISTRADOR

    Route::post('admin', [UserController::class, 'createAdmin']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);

    //CATEGORIES ADMINISTRADOR
    Route::post('category', [CategoryController::class, 'store']);
    Route::put('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);

    //COURSES ADMINISTRADOR
    Route::post('course', [CourseController::class, 'store']);
    Route::put('course/{id}', [CourseController::class, 'update']);
    Route::delete('course/{id}', [CourseController::class, 'destroy']);

    //ENROLMENTS ADMINISTRADOR
    Route::get('enrollments', [EnrollmentController::class, 'index']);
    Route::put('enrollment/{id}', [EnrollmentController::class, 'update']);

    //EVALUATIONS ADMINISTRADOR
    Route::get('evaluations', [EvaluationController::class, 'index']); //paginada en 10

    Route::post('evaluation', [EvaluationController::class, 'store']);
    Route::delete('evaluation/{id}', [EvaluationController::class, 'destroy']);
    Route::put('evaluation/{id}', [EvaluationController::class, 'update']);
});



