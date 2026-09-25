<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Manager</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            body {
                background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
                font-family: Arial, sans-serif;
                margin: 0;
                color: #1f2937;
            }

            .topbar {
                position: sticky;
                top: 0;
                z-index: 10;
                padding: 16px 20px;
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(6px);
                border-bottom: 1px solid rgba(229, 231, 235, 0.8);
            }

            .menu-wrap {
                position: relative;
                display: inline-block;
            }

            .menu-btn {
                width: 48px;
                height: 48px;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                background: white;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                position: relative;
                z-index: 20;
            }

            .menu-icon {
                width: 20px;
                height: 14px;
                position: relative;
            }

            .menu-icon span {
                position: absolute;
                left: 0;
                width: 100%;
                height: 2px;
                background: #374151;
                border-radius: 2px;
            }

            .menu-icon span:nth-child(1) { top: 0; }
            .menu-icon span:nth-child(2) { top: 6px; }
            .menu-icon span:nth-child(3) { bottom: 0; }

            .menu-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.15);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.25s ease;
            }

            .menu-overlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            .menu-dropdown {
                position: fixed;
                top: 0;
                left: -260px;
                width: 220px;
                height: 100vh;
                background: white;
                border-right: 1px solid #e5e7eb;
                box-shadow: 12px 0 30px rgba(15, 23, 42, 0.12);
                padding: 80px 18px 20px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                transition: left 0.3s ease;
                z-index: 15;
            }

            .menu-dropdown.open {
                left: 0;
            }

            .menu-item {
                display: block;
                text-decoration: none;
                color: #1f2937;
                padding: 12px 14px;
                border-radius: 10px;
                font-weight: 600;
                background: #f9fafb;
                cursor: pointer;
            }

            .menu-item:hover {
                background: #eef2ff;
                color: #4338ca;
            }

            .task-panel {
                position: fixed;
                top: 0;
                left: -100%;
                width: min(560px, 90vw);
                height: 100vh;
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                border-right: 1px solid #e5e7eb;
                box-shadow: 18px 0 36px rgba(15, 23, 42, 0.15);
                padding: 30px 24px;
                overflow-y: auto;
                transition: left 0.3s ease;
                z-index: 25;
            }

            .task-panel.open {
                left: 0;
            }

            .task-panel-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 24px;
            }

            .task-panel-header h2 {
                margin: 0;
                font-size: 2rem;
            }

            .close-panel {
                border: none;
                background: #eef2ff;
                color: #3730a3;
                width: 38px;
                height: 38px;
                border-radius: 10px;
                font-size: 1.2rem;
                cursor: pointer;
            }

            main {
                max-width: 960px;
                margin: 40px auto 60px;
                padding: 24px;
            }

            .home-hero {
                background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
                border: 1px solid #e5e7eb;
                border-radius: 24px;
                padding: 28px 30px;
                margin-bottom: 28px;
                box-shadow: 0 12px 30px rgba(79, 70, 229, 0.08);
            }

            .home-hero h1 {
                margin: 0 0 12px;
                font-size: 3rem;
                color: #111827;
            }

            .home-hero p {
                margin: 0 0 18px;
                color: #4b5563;
                font-size: 1.08rem;
                max-width: 620px;
            }

            .hero-actions {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .secondary-btn {
                display: inline-block;
                text-decoration: none;
                background: #e0e7ff;
                color: #3730a3;
                border: 1px solid #c7d2fe;
                border-radius: 10px;
                padding: 10px 16px;
                font-weight: 700;
            }

            .header {
                margin-bottom: 24px;
            }

            .header h1 {
                font-size: 2.5rem;
                margin: 0 0 8px;
                color: #111827;
            }

            .header p {
                margin: 0;
                color: #4b5563;
                font-size: 1rem;
            }

            .card {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid #e5e7eb;
                border-radius: 18px;
                box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
                padding: 20px;
            }

            .task-form {
                margin-bottom: 24px;
            }

            .task-form-grid {
                display: grid;
                grid-template-columns: 1.5fr 1.2fr auto;
                gap: 16px;
            }

            label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                margin-bottom: 8px;
                color: #374151;
            }

            input {
                width: 100%;
                box-sizing: border-box;
                border: 1px solid #d1d5db;
                border-radius: 10px;
                padding: 10px 12px;
                font-size: 0.95rem;
                background: #fff;
            }

            input:focus {
                outline: 2px solid rgba(99, 102, 241, 0.2);
                border-color: #6366f1;
            }

            .add-btn, .delete-btn, .toggle-btn {
                border: none;
                cursor: pointer;
                transition: 0.2s ease;
            }

            .add-btn {
                background: #4f46e5;
                color: white;
                padding: 11px 16px;
                border-radius: 10px;
                font-weight: 600;
                min-width: 120px;
            }

            .add-btn:hover {
                background: #4338ca;
            }

            .task-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .task-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 12px 14px;
                background: #f9fafb;
            }

            .task-left {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .toggle-btn {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                border: 2px solid #cbd5e1;
                background: white;
                font-size: 0.75rem;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .toggle-btn.completed {
                background: #22c55e;
                border-color: #22c55e;
            }

            .task-title {
                margin: 0;
                font-weight: 600;
                color: #111827;
            }

            .task-title.completed {
                text-decoration: line-through;
                color: #9ca3af;
            }

            .task-description {
                margin: 4px 0 0;
                color: #6b7280;
                font-size: 0.85rem;
            }

            .delete-btn {
                background: #fff1f2;
                color: #dc2626;
                border: 1px solid #fecdd3;
                border-radius: 9px;
                padding: 8px 12px;
                font-weight: 600;
            }

            .delete-btn:hover {
                background: #ffe4e6;
            }

            .empty-state {
                margin: 0;
                color: #6b7280;
                font-size: 0.95rem;
            }

            @media (max-width: 640px) {
                .task-form-grid {
                    grid-template-columns: 1fr;
                }

                .task-item {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .delete-btn {
                    width: 100%;
                }
            }
        </style>
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
            
            <a href="#" class="menu-item">Home</a>
            <button type="button" class="menu-item" id="openTaskPanel">Task Manager</button>
            
        </nav>

        <aside class="task-panel" id="taskPanel" aria-label="Task manager panel">
            <div class="task-panel-header">
                <h2>Task Manager</h2>
                <button type="button" class="close-panel" id="closeTaskPanel" aria-label="Close task manager">×</button>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="card task-form">
                @csrf
                <div class="task-form-grid">
                    <div>
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" required maxlength="255" placeholder="Add a task">
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <input id="description" name="description" type="text" placeholder="Optional notes">
                    </div>
                    <div style="display: flex; align-items: end;">
                        <button type="submit" class="add-btn">Add Task</button>
                    </div>
                </div>
            </form>

            <section class="card" id="tasks">
                @if ($tasks->isEmpty())
                    <p class="empty-state">No tasks yet. Add one above to get started.</p>
                @else
                    <ul class="task-list">
                        @foreach ($tasks as $task)
                            <li class="task-item">
                                <div class="task-left">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="toggle-btn {{ $task->completed ? 'completed' : '' }}" aria-label="Toggle task completion">
                                            @if ($task->completed)
                                                ✓
                                            @endif
                                        </button>
                                    </form>

                                    <div>
                                        <p class="task-title {{ $task->completed ? 'completed' : '' }}">
                                            {{ $task->title }}
                                        </p>
                                        @if ($task->description)
                                            <p class="task-description">{{ $task->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </aside>

        <main>
            <section class="home-hero">
                <h1>Welcome in, Ivan</h1>
                <div class="hero-actions">
                    <a href="#" class="secondary-btn">Explore</a>
                </div>
            </section>
        </main>

        <script>
            const menuToggle = document.getElementById('menuToggle');
            const sideMenu = document.getElementById('sideMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            const taskPanel = document.getElementById('taskPanel');
            const openTaskPanelBtn = document.getElementById('openTaskPanel');
            const closeTaskPanelBtn = document.getElementById('closeTaskPanel');

            menuToggle.addEventListener('click', () => {
                sideMenu.classList.toggle('open');
                menuOverlay.classList.toggle('active');
            });

            menuOverlay.addEventListener('click', () => {
                sideMenu.classList.remove('open');
                menuOverlay.classList.remove('active');
                taskPanel.classList.remove('open');
            });

            openTaskPanelBtn.addEventListener('click', () => {
                sideMenu.classList.remove('open');
                menuOverlay.classList.add('active');
                taskPanel.classList.add('open');
            });

            closeTaskPanelBtn.addEventListener('click', () => {
                taskPanel.classList.remove('open');
                menuOverlay.classList.remove('active');
            });
        </script>
    </body>
</html>
