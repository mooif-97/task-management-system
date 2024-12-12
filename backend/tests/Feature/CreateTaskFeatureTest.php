<?php
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('create tasks successfully', function () {
    $createData = ['title'=>'test title&&', 'description' => 'test description', 'created_by' => 'someone'];
    $response = $this->post("/api/tasks", $createData);

    $response->assertStatus(201)->assertJson([
        'item' =>  [
            'title'=>'test title&&',
            'description'=>'test description',
            'created_by'=>'someone',
        ],
        'message' => 'Task created successfully.'
    ]);
});

it('returns validation error if required input is not provided when creating new task', function () {
    $createData = ['title'=> null, 'description' => null, 'created_by' => 'someone'];
    $response = $this->post("/api/tasks", $createData);

    $response->assertStatus(422)->assertJson([
        'errors' =>  [
            'title' =>  ['The title field is required.'],
            'description'=> ['The description field is required.'],
        ],
    ]);
});