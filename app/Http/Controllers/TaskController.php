<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks-create');
    }

    public function index()
    {
        $tasks = Task::orderByRaw("CASE WHEN status = 'Completed' THEN 1 ELSE 0 END")
            ->orderBy('due_date')
            ->orderByDesc('created_at')
            ->get();

        return view('tasks', compact('tasks'));
    }

    public function calendar()
    {
        $month = now()->startOfMonth();
        $tasks = Task::whereBetween('due_date', [
            $month->toDateString(),
            $month->copy()->endOfMonth()->toDateString(),
        ])
            ->orderBy('due_date')
            ->get();
        $tasksByDate = $tasks->groupBy(function (Task $task) {
            return Carbon::parse($task->due_date)->format('Y-m-d');
        });

        return view('calendar', compact('month', 'tasksByDate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => 'required|in:Pending,Completed',
            'due_date' => ['nullable', 'date'],
        ]);

        Task::create([
            'task_name' => $validated['task_name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => 'required|in:Pending,Completed',
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function toggle(Task $task)
    {
        $task->update([
            'status' => $task->status === 'Completed' ? 'Pending' : 'Completed',
        ]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
