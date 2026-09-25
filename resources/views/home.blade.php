<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
            <div class="dashboard-heading">
                <h1>Welcome in, Ivan!</h1>
            
            </div>

            <section class="dashboard-grid">
                <article class="dashboard-panel">
                    <div class="panel-heading">
                        <h2>Task Manager</h2>
                        <a href="{{ route('tasks.index') }}">View all</a>
                    </div>

                    @if ($pendingTasks->isEmpty())
                        <p class="dashboard-empty">No pending tasks.</p>
                    @else
                        <ul class="dashboard-task-list">
@if ($pendingTasks->isEmpty())
    <p class="dashboard-empty">No pending tasks.</p>
@else
                            @foreach ($pendingTasks->take(5) as $task)
                                <li>
                                    <span class="dashboard-task-number">{{ $loop->iteration }}</span>
                                    <span>{{ $task->task_name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                        </ul>
                    @endif
                </article>

                <article class="dashboard-panel">
                    <div class="panel-heading">
                        <h2>Calendar</h2>
                        <a href="{{ route('calendar') }}">View all</a>
                    </div>

                    @if ($calendarTasks->isEmpty())
                        <p class="dashboard-empty">No due dates yet.</p>
                    @else
                        <ul class="dashboard-task-list calendar-preview">
                            @foreach ($calendarTasks as $task)
                                <li>
                                    <span>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                    <strong>{{ $task->task_name }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            </section>
        </main>

        <script src="{{ asset('js/menu.js') }}"></script>
    </body>
</html>
