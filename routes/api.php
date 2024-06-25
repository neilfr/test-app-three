<?php

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

Route::name('api.')->group(function () {
    Route::name('tasks.')->group(function () {
        Route::get('/tasks/{task}', [\App\Http\Controllers\Api\TaskController::class, 'show'])->name('show');
        Route::get('/tasks', [\App\Http\Controllers\Api\TaskController::class, 'index'])->name('index');    
        Route::post('/tasks', [\App\Http\Controllers\Api\TaskController::class, 'store'])->name('store');
        Route::patch('/tasks/{task}', [\App\Http\Controllers\Api\TaskController::class, 'update'])->name('update');
        Route::delete('/tasks/{task}', [\App\Http\Controllers\Api\TaskController::class, 'destroy'])->name('destroy');
    });
});
