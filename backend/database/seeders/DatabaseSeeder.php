<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'user_id' => 'test',
            'email' => 'test0@example.com',
            'password' => bcrypt('test1234')
        ],
        [
            'user_id' => 'test1',
            'email' => 'test1@example.com',
            'password' => bcrypt('test1234')
        ],
        [
            'user_id' => 'test2',
            'email' => 'test2@example.com',
            'password' => bcrypt('test1234')
        ]);

        Task::factory()->count(10)->create();

        // factory(Task::class, 10)->create();
    }
}
