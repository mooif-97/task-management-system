<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\TransactionStatusSeeder;

uses(DatabaseMigrations::class);

// test('create new task', function () {
//     // dd(env('DB_CONNECTION'));
//     $tasks = Task::factory()->create();
//     $this->assertModelExists($tasks);
// });
