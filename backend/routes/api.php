<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminStatsController;
// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Survey questions
Route::get('/questions', [QuestionController::class, 'index']);

// Responses
Route::post('/responses', [ResponseController::class, 'store']);
Route::get('/result/{token}', [ResponseController::class, 'showByToken']);

// Admin-only routes (protected by JWT auth)
Route::middleware('auth:api')->prefix('admin')->group(function () {
    Route::get('/respondents', [AdminController::class, 'index']);
    Route::get('/respondents/{token}', [AdminController::class, 'show']);
    Route::delete('/respondents/{id}', [AdminController::class, 'destroy']);
});

Route::get('/dashboard-stats', [AdminStatsController::class, 'getDashboardStats']);



