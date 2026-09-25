<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $pendingTasks = Task::where('status', 'Pending')
        ->orderBy('due_date')
        ->orderByDesc('created_at')
        ->get();

    $calendarTasks = Task::whereNotNull('due_date')
        ->orderBy('due_date')
        ->limit(5)
        ->get();

    return view('home', compact('pendingTasks', 'calendarTasks'));
})->name('home');

Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/calendar', [TaskController::class, 'calendar'])->name('calendar');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
