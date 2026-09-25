<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Task</title>
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
                        <h1>New Task</h1>
                        <p>Add a task to your task manager.</p>
                    </div>
                    <a href="{{ route('tasks.index') }}" class="cancel-btn page-back-btn">Back to Tasks</a>
                </div>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="card task-form new-task-form">
                @csrf
                <div class="task-form-grid">
                    <div>
                        <label for="task_name">Task name</label>
                        <input id="task_name" name="task_name" type="text" required maxlength="255" placeholder="Add a task" autofocus>
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <input id="description" name="description" type="text" placeholder="Optional notes">
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="Pending" selected>Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div>
                        <label for="due_date">Due date</label>
                        <input id="due_date" name="due_date" type="date">
                    </div>
                    <div class="page-form-actions">
                        <button type="submit" class="add-btn">Add Task</button>
                        <a href="{{ route('tasks.index') }}" class="cancel-btn">Cancel</a>
                    </div>
                </div>
            </form>
        </main>

        <script src="{{ asset('js/menu.js') }}"></script>
    </body>
</html>
