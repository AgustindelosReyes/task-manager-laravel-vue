<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// En routes/web.php
Route::resource('tasks', TaskController::class);

// O si usas rutas separadas para cada acción
Route::put('tasks/{id}/complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggleComplete');

Route::get('/', [TaskController::class, 'index']);
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
// Route::get('/', function () {
//     return view('welcome');
// });
