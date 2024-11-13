<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/task/start', [TaskController::class, 'startTask']);
Route::post('/task/stop', [TaskController::class, 'stopTask']);
Route::get('/tasks/today', [TaskController::class, 'resumeToday']);
