<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $deadline = fake()->dateTime();

        return [
            'title' => fake()->sentence(),
            'description' => fake()->realText(),
            'is_completed' => fake()->boolean(),
            'created_by' => 1,
            'deadline' => $deadline,
            // Define 'completed_at' somente se a deadline já passou
            'completed_at' => ($deadline < now()) ? fake()->dateTime() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
