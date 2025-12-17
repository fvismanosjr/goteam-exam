<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskItemController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('task-item-sort', [TaskItemController::class, 'sort']);
    Route::resource('tasks', TaskController::class);
    Route::resource('tasks.items', TaskItemController::class);
});