<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('get tasks by pagination with empty search criteria', function () {
    $user = User::factory()->create();

    // Simulate authentication by acting as the created user
    $this->actingAs($user);

    $response = $this->post('/api/tasks-by-pagination', []);

    $response->assertStatus(200);
});

it('throws error when get tasks by pagination with invalid search criteria like page and pageSize', function () {
    $user = User::factory()->create();

    // Simulate authentication by acting as the created user
    $this->actingAs($user);

    $response = $this->post('/api/tasks-by-pagination', ['page'=>'testInvalid', 'page_size' => 'testInvalid']);

    $response->assertStatus(422)->assertJsonValidationErrors(['page', 'page_size'])->assertExactJson([
        'errors'=>[
            'page'=> ['The page field must be a number.'],
            'page_size'=> ['The page size field must be a number.']
        ]
    ]);

});
