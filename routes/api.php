<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LetterController;
use Illuminate\Support\Facades\Route;

Route::any('health-check', fn() => ['status' => 'ok']);

Route::post('goo-login', [AuthController::class, 'loginUseGooToken']);
Route::post('pas-login', [AuthController::class, 'loginUsePassword']);
Route::get('/read/{uuid}', [LetterController::class, 'update']);

Route::middleware(['auth:sanctum',])->group(function () {
    Route::get('/letters', [LetterController::class, 'index']);
    Route::post('/letters', [LetterController::class, 'store']);
});



