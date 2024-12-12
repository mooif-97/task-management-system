<?php
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('delete tasks successfully', function () {
    $task = Task::create([
        'title' => 'test title delete',
        'description' => 'test description',
        'due_date' => null
    ]);
    $taskId = $task['task_id'];

    $response = $this->delete("/api/tasks/$taskId");

    $response->assertStatus(200)->assertJson([
        'message' => "Task with [Task ID: $taskId] deleted successfully."
    ]);
});

it('returns task not found error when deleting a non existing task', function () {
    $task = Task::create([
        'title' => 'test title',
        'description' => 'test description',
        'due_date' => null
    ]);
    $taskId = 'non-existing-id';

    $response = $this->delete("/api/tasks/$taskId");

    $response->assertStatus(404)->assertJson([
        'message' => "Task with [Task ID: $taskId] is not found."
    ]);
});