# Personal Task Manager

Laravel mini project for managing personal tasks.

## Project Information

- **Project Code:** WST21-PM-2026-SF
- **Student Name:** Maramara,ivan
- **Course & Year:** BSIT 2ND YEAR SEC 7
- **Database Used:** MySQL/MariaDB

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status: Pending or Completed
- Set a due date
- Calendar view for tasks with due dates
- Separate Pending and Completed task sections
- Responsive dashboard and navigation menu

## Technologies

- Laravel 12
- PHP 8.2+
- Blade templates
- Eloquent ORM
- SQLite
- HTML and CSS
- PHPUnit feature tests

## Laravel Structure

- **Routes:** `routes/web.php`
- **Controller:** `app/Http/Controllers/TaskController.php`
- **Model:** `app/Models/Task.php`
- **Database migrations:** `database/migrations/`
- **Blade views:** `resources/views/`
- **Stylesheets:** `resources/css/` and `public/css/`

## Database Fields

The `tasks` table contains:

- `id`
- `task_name`
- `description`
- `status`
- `due_date`
- `created_at`
- `updated_at`

## Local Setup

1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env`.
4. Run `php artisan key:generate`.
5. Create a database named `task_manager` in phpMyAdmin.
6. Make sure `.env` uses `DB_CONNECTION=mysql` and the correct MySQL credentials.
7. Run `php artisan migrate`.
8. Start the app with `php artisan serve`.
9. Open the URL shown by Laravel in your browser.

## Testing

Run the feature test with:

```bash
php artisan test --filter=TaskManagerTest --compact
```

The test covers the Home page, Task Manager page, New Task page, Calendar page, adding, editing, status updates, and deleting tasks.
