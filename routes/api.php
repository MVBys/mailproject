<?php

use App\Http\Controllers\LetterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('health-check', fn() => ['status'=>'ok']);

Route::get('/letters/{user}', [LetterController::class, 'index']);
Route::post('/letters', [LetterController::class, 'store']);
Route::get('/letter-opened/{uuid}', [LetterController::class, 'update'])->whereUuid('uuid');

