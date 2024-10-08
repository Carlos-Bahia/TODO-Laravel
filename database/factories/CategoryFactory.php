<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $cores = [
            'Red', 'Blue', 'Green', 'Yellow', 'Black',
            'White', 'Purple', 'Orange', 'Pink', 'Gray',
        ];
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'color' => $this->faker->randomElement($cores),
            'created_for' => 1,
        ];
    }
}
