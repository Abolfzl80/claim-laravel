<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClaimController;
use App\Http\Controllers\Api\ClaimReactionController;
use App\Http\Controllers\Api\ChallenegeController;
use App\Http\Controllers\Api\NotifController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::get('/claim', [ClaimController::class, 'index']);
    Route::post('/claim/create', [ClaimController::class, 'store']);
    Route::put('/claim/{id}/update', [ClaimController::class, 'update']);
    Route::delete('/claim/{id}/delete', [ClaimController::class, 'destroy']);

    Route::get('/claim/reaction', [ClaimReactionController::class, 'index']);
    Route::post('/claim/{id}/reaction', [ClaimReactionController::class, 'store']);
    Route::delete('/claim/reaction/{id}/delete', [ClaimReactionController::class, 'destroy']);    

    Route::post('/claim/challenge/{id}', [ChallenegeController::class, 'store']);
    Route::post('/claim/challenge/{id}/accept', [ChallenegeController::class, 'accept']);
    Route::post('/claim/challenge/{id}/reject', [ChallenegeController::class, 'reject']);

    Route::get('/claim/notifcations', [NotifController::class, 'index']);
});