<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::any('health-check', fn() => ['status' => 'ok']);

Route::post('goo-login', [AuthController::class, 'loginUseGooToken']);
Route::post('pas-login', [AuthController::class, 'loginUsePassword']);
Route::get('/read/{uuid}', [LetterController::class, 'update']);

//todo Need authorization
Route::post('/users/set-pro', [UserController::class, 'setProStatus']);
Route::post('/users/remove-pro', [UserController::class, 'removeProStatus']);

Route::middleware(['auth:sanctum',])->group(function () {
    Route::get('/letters', [LetterController::class, 'index']);
    Route::post('/letters', [LetterController::class, 'store']);

    Route::get('/users/authorized', [UserController::class, 'authorized']);
    Route::delete('/users', [UserController::class, 'destroy']);

    Route::get('/settings/default-list', [SettingController::class, 'getDefaultList']);
    Route::get('/settings', [SettingController::class, 'getUserSetting']);
    Route::patch('/settings', [SettingController::class, 'updateUserSettings']);

});



