<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])
    ->name('tasks.export.csv');

Route::resource('tasks', TaskController::class);