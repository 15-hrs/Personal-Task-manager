<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Manager</title>
        <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
    </head>
    <body>
        <header class="topbar">
            <div class="menu-wrap">
                <button type="button" class="menu-btn" aria-label="Open menu" id="menuToggle">
                    <span class="menu-icon" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
        </header>

        <div class="menu-overlay" id="menuOverlay"></div>

        <nav class="menu-dropdown" id="sideMenu" aria-label="Main menu">
            <div class="menu-title">Menu</div>
            <a href="{{ route('home') }}" class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('tasks.index') }}" class="menu-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">Task Manager</a>
            <a href="{{ route('calendar') }}" class="menu-item {{ request()->routeIs('calendar') ? 'active' : '' }}">Calendar</a>
        </nav>

        <main>
            <div class="header">
                <div class="header-row">
                    <div>
                        <h1>Task Manager</h1>
                        <p>Keep track of what needs to be done.</p>
                    </div>
                    <a href="{{ route('tasks.create') }}" class="header-add-btn">
                        + Add Task
                    </a>
                </div>
            </div>

            <section class="task-groups">
                @if ($tasks->isEmpty())
                    <p class="empty-state">No tasks yet. Add one above to get started.</p>
                @else
                    @foreach (['Pending' => $tasks->where('status', 'Pending'), 'Completed' => $tasks->where('status', 'Completed')] as $status => $statusTasks)
                        <div class="task-group card">
                            <h2 class="task-group-title status-{{ strtolower($status) }}">{{ $status }} Tasks</h2>

                            @if ($statusTasks->isEmpty())
                                <p class="empty-state">No {{ strtolower($status) }} tasks.</p>
                            @else
                                <ul class="task-list">
                        @foreach ($statusTasks as $task)
                            <li class="task-item">
                                <div class="task-left">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="toggle-btn {{ $task->status === 'Completed' ? 'completed' : '' }}" aria-label="Toggle task completion">
                                            @if ($task->status === 'Completed')
                                                ✓
                                            @endif
                                        </button>
                                    </form>

                                    <div>
                                        <p class="task-title {{ $task->status === 'Completed' ? 'completed' : '' }}">
                                            {{ $task->task_name }}
                                        </p>
                                        <div class="task-meta">
                                            <span class="task-status status-{{ strtolower($task->status) }}">{{ $task->status }}</span>
                                            @if ($task->due_date)
                                                <span class="task-due-date">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                        @if ($task->description)
                                            <p class="task-description">{{ $task->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="task-actions">
                                    <button type="button" class="edit-btn" onclick="document.getElementById('edit-task-{{ $task->id }}').style.display='block'">Edit</button>

                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </div>
                            </li>

                            <li id="edit-task-{{ $task->id }}" class="task-edit" style="display: none;">
                                <form action="{{ route('tasks.update', $task) }}" method="POST" class="card task-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="task-form-grid">
                                        <div>
                                            <label for="task_name_{{ $task->id }}">Task name</label>
                                            <input id="task_name_{{ $task->id }}" name="task_name" type="text" value="{{ $task->task_name }}" required>
                                        </div>
                                        <div>
                                            <label for="description_{{ $task->id }}">Description</label>
                                            <input id="description_{{ $task->id }}" name="description" type="text" value="{{ $task->description }}">
                                        </div>
                                        <div>
                                            <label for="status_{{ $task->id }}">Status</label>
                                            <select id="status_{{ $task->id }}" name="status">
                                                <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="due_date_{{ $task->id }}">Due date</label>
                                            <input id="due_date_{{ $task->id }}" name="due_date" type="date" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                                        </div>
                                        <div style="display: flex; align-items: end; gap: 10px;">
                                            <button type="submit" class="save-btn">Save</button>
                                            <button type="button" class="delete-btn" onclick="document.getElementById('edit-task-{{ $task->id }}').style.display='none'">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @endif
            </section>
        </main>

        <script src="{{ asset('js/menu.js') }}"></script>
    </body>
</html>
