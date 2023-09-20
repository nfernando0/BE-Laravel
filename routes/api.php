<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\NewsController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('news', [NewsController::class, 'store'])->middleware('admin');
    Route::put('news/{id}', [NewsController::class, 'update'])->middleware('admin');
    Route::delete('news/{id}', [NewsController::class, 'destroy'])->middleware('admin');
    Route::get('news/{id}', [NewsController::class, 'show']);

    Route::post('comments', [CommentsController::class, 'store']);
    Route::delete('comments/{id}', [CommentsController::class, 'destroy']);
});

Route::get('news', [NewsController::class, 'index']);
