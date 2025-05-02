<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::delete('/tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulkDelete');
// Route::post('/tasks/bulk-store', [TaskController::class, 'bulkStore'])->name('tasks.bulkStore');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');




// En routes/web.php
Route::resource('tasks', TaskController::class);

Route::get('/', [TaskController::class, 'index']);
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('tasks/{id}/complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggleComplete');


// Route::get('/', function () {
//     return view('welcome');
// });
