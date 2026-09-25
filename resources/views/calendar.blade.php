<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calendar</title>
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
                        <h1>Calendar</h1>
                        <p>See your tasks by due date.</p>
                    </div>
                    <a href="{{ route('tasks.create') }}" class="header-add-btn">+ Add Task</a>
                </div>
            </div>

            <section class="card calendar-card">
                <div class="calendar-month-title">
                    {{ $month->format('F Y') }}
                </div>

                <div class="calendar-weekdays">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekday)
                        <div>{{ $weekday }}</div>
                    @endforeach
                </div>

                <div class="calendar-grid">
                    @for ($emptyDay = 0; $emptyDay < $month->dayOfWeek; $emptyDay++)
                        <div class="calendar-day calendar-day-empty"></div>
                    @endfor

                    @for ($dayNumber = 1; $dayNumber <= $month->daysInMonth; $dayNumber++)
                        @php
                            $date = $month->copy()->day($dayNumber);
                            $dateTasks = $tasksByDate->get($date->format('Y-m-d'), collect());
                        @endphp

                        <div class="calendar-day {{ $date->isToday() ? 'today' : '' }}">
                            <span class="calendar-day-number">{{ $dayNumber }}</span>

                            @foreach ($dateTasks as $task)
                                <div class="calendar-task-chip status-{{ strtolower($task->status) }}">
                                    {{ $task->task_name }}
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </section>
        </main>

        <script src="{{ asset('js/menu.js') }}"></script>
    </body>
</html>
