<?php
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('update tasks successfully', function () {
    $task = Task::create([
        'title' => 'test title',
        'description' => 'test description',
        'due_date' => null
    ]);
    $taskId = $task['task_id'];
    $newDate = '2024-12-12T10:11:40.550Z';

    $createData = ['title'=>'new title test', 'description' => 'new test description', 'due_date' => $newDate];
    $response = $this->put("/api/tasks/$taskId", $createData);

    $response->assertStatus(200)->assertJson([
        'item' => [
            'title'=> 'new title test',
            'description'=> 'new test description',
            'due_date' => $newDate
        ],
        'message' => "Task with [Task ID: $taskId] updated successfully."
    ]);
});

it('returns task not found error when updating a non existing task', function () {
    $task = Task::create([
        'title' => 'test title',
        'description' => 'test description',
        'due_date' => null
    ]);
    $taskId = 'non-existing-id';
    $newDate = '2024-12-12T10:11:40.550Z';

    $createData = ['title'=>'new title test', 'description' => 'new test description', 'due_date' => $newDate];
    $response = $this->put("/api/tasks/$taskId", $createData);

    $response->assertStatus(404)->assertJson([
        'message' => "Task with [Task ID: $taskId] is not found."
    ]);
});

it('returns validation error if required input is not provided when updating task', function () {
    $task = Task::create([
        'title' => 'test title',
        'description' => 'test description',
        'due_date' => null
    ]);
    $taskId = $task['task_id'];
    $updateData = ['due_date'=> null];
    $response = $this->put("/api/tasks/$taskId", $updateData);

    $response->assertStatus(422)->assertJson([
        'errors' =>  [
            'title' =>  ['The title field is required.'],
            'description'=> ['The description field is required.'],
        ],
    ]);
});