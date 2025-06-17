<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//user Routes no t using sanctum and middleware
Route::get('/users', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::post('/user/create-admin', [UserController::class, 'createAdmin']);
Route::get('/user/{id}', [UserController::class, 'show']);
//enviar Json no form data
Route::put('/user/{id}', [UserController::class, 'update']);


