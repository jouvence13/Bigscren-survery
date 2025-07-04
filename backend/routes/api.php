<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\AuthController;


// Admin login/logout
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Survey questions
Route::get('/questions', [QuestionController::class, 'index']);
