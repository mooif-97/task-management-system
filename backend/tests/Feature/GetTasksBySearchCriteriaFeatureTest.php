<?php
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('get tasks by pagination with empty search criteria', function () {
    $response = $this->post('/api/tasks-by-pagination', []);
    $response->assertStatus(200);
});

it('get tasks by pagination with valid pagination aspects in search criteria', function () {
    $totalSize = 30;
    $pageSize = 5;

    Task::factory()->count($totalSize )->create();
    $response = $this->post('/api/tasks-by-pagination', ['page' => 2, 'page_size' => $pageSize ]);
    $response->assertStatus(200)->assertJson([
        'data' => [],
        'page_details' => [
            'page_size' => $pageSize ,
            'current_page' => 2,
            'total' => $totalSize ,
            'last_page' => $totalSize / $pageSize,
        ]
    ])->assertJsonCount($pageSize, 'data');
});

it('throws error when get tasks by pagination with invalid search criteria like page and pageSize', function () {
    $this->actingAs($this->user);

    $response = $this->post('/api/tasks-by-pagination', ['page'=>'testInvalid', 'page_size' => -200]);

    $response->assertStatus(422)->assertJsonValidationErrors(['page', 'page_size'])->assertExactJson([
        'errors'=>[
            'page'=> ['The page field must be a number.'],
            'page_size'=> ['The page size field must be at least 1.']
        ]
    ]);
});