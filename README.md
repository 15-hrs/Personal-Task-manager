# Personal Task Manager

A Laravel mini project for managing personal tasks. The system allows users to create, view, edit, delete, and track tasks with due dates and completion status.

## Project Information

* **Project Code:** WST21-PM-2026-SF
* **Student Name:** Maramara, Ivan L.
* **Course & Year:** BSIT 2nd Year, Section 7
* **Database:** MySQL/MariaDB

## Project Outputs
![image alt](https://github.com/15-hrs/Personal-Task-manager/blob/77e3079d3ad434f49cc0526790689581d8e0e9bc/Output_Home.png)
![image alt](https://github.com/15-hrs/Personal-Task-manager/blob/77e3079d3ad434f49cc0526790689581d8e0e9bc/Output_Task.png)



## Features

* Add tasks
* View tasks
* Edit tasks
* Delete tasks
* Update task status

  * Pending
  * Completed
* Set due dates
* Calendar view for tasks with due dates
* Separate Pending and Completed task sections
* Responsive dashboard
* Responsive navigation menu

## Technologies

* **Laravel:** 12
* **PHP:** 8.2+
* **Blade Templates**
* **Eloquent ORM**
* **MySQL/MariaDB**
* **HTML5**
* **CSS3**
* **PHPUnit**

## Project Structure

```text
Personal Task Manager
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── TaskController.php
│   └── Models/
│       └── Task.php
│
├── database/
│   └── migrations/
│
├── resources/
│   └── views/
│
├── public/
│   └── css/
│
├── routes/
│   └── web.php
│
└── tests/
```

## Database Structure

The `tasks` table contains the following fields:

| Field         | Description                             |
| ------------- | --------------------------------------- |
| `id`          | Unique task ID                          |
| `task_name`   | Name or title of the task               |
| `description` | Task details                            |
| `status`      | Current task status                     |
| `due_date`    | Task deadline                           |
| `created_at`  | Date and time the task was created      |
| `updated_at`  | Date and time the task was last updated |

## Local Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
```

Navigate to the project folder:

```bash
cd <project-folder>
```

### 2. Install Dependencies

Install the PHP dependencies:

```bash
composer install
```

### 3. Configure the Environment

Copy the example environment file:

```bash
cp .env.example .env
```

For Windows, you can also manually copy `.env.example` and rename the copy to `.env`.

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Create the Database

Create a database named:

```text
task_manager
```

You can create the database using **phpMyAdmin** or MySQL/MariaDB.

### 6. Configure the Database

Update your `.env` file with your MySQL/MariaDB credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

Change `DB_USERNAME` and `DB_PASSWORD` if your local database uses different credentials.

### 7. Run the Migrations

```bash
php artisan migrate
```

### 8. Start the Laravel Development Server

```bash
php artisan serve
```

Laravel will display the local URL in the terminal, usually:

```text
http://127.0.0.1:8000
```

Open the URL in your browser.

## Testing

Run the feature tests using:

```bash
php artisan test --filter=TaskManagerTest --compact
```

The test covers the following functionality:

* Home page
* Task Manager page
* New Task page
* Calendar page
* Adding tasks
* Editing tasks
* Updating task status
* Deleting tasks

## Main Laravel Components

### Routes

The application routes are located in:

```text
routes/web.php
```

### Controller

Task-related logic is handled by:

```text
app/Http/Controllers/TaskController.php
```

### Model

The Task model is located at:

```text
app/Models/Task.php
```

It uses Laravel's Eloquent ORM to interact with the database.

### Migrations

Database table definitions are stored in:

```text
database/migrations/
```

### Blade Views

The application's user interface is stored in:

```text
resources/views/
```

### Stylesheets

CSS files are located in:

```text
resources/css/
public/css/
```

## Task Status

Each task can have one of two statuses:

```text
Pending
Completed
```

Tasks can be updated from Pending to Completed and can also be edited when necessary.

## Calendar

The calendar view displays tasks that have a specified due date. This allows users to easily see upcoming deadlines and organize their tasks.

## Author

**Maramara, Ivan L.**

BSIT 2nd Year, Section 7

**Project Code:** WST21-PM-2026-SF
