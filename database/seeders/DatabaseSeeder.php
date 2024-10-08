<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'password' => bcrypt('teste123'),
            'email_verified_at' => now()
        ]);

        $categories = Category::factory()->count(10)->create();

        $tasks = Task::factory()->count(30)->create();

        foreach ($tasks as $task) {
            $randomCategories = $categories->random(2);
            $task->categories()->attach($randomCategories);
        }
    }
}
