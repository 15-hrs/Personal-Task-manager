<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_manage_tasks(): void
    {
        $homeResponse = $this->get('/');
        $homeResponse->assertOk();
        $homeResponse->assertSee('Welcome in, Ivan!');
        $homeResponse->assertSee('Task Manager');
        $homeResponse->assertSee('Calendar');

        $taskPageResponse = $this->get('/tasks');
        $taskPageResponse->assertOk();
        $taskPageResponse->assertSee('Task Manager');

        $calendarResponse = $this->get('/calendar');
        $calendarResponse->assertOk();
        $calendarResponse->assertSee('Calendar');

        $newTaskPageResponse = $this->get('/tasks/create');
        $newTaskPageResponse->assertOk();
        $newTaskPageResponse->assertSee('New Task');
        $newTaskPageResponse->assertSee('name="task_name"', false);

        $createResponse = $this->post('/tasks', [
            'task_name' => 'Write project brief',
            'description' => 'Outline the goals and milestones for the sprint.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $createResponse->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Write project brief',
            'description' => 'Outline the goals and milestones for the sprint.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $task = Task::first();

        $updateResponse = $this->put('/tasks/' . $task->id, [
            'task_name' => 'Write project brief updated',
            'description' => 'Updated goals and milestones for the sprint.',
            'status' => 'Completed',
            'due_date' => '2026-10-01',
        ]);
        $updateResponse->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Write project brief updated',
            'status' => 'Completed',
            'due_date' => '2026-10-01',
        ]);

        $toggleResponse = $this->patch('/tasks/' . $task->id . '/toggle');
        $toggleResponse->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Pending',
        ]);

        $deleteResponse = $this->delete('/tasks/' . $task->id);
        $deleteResponse->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
