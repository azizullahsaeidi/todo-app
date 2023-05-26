<?php

namespace Database\Factories;

use App\Models\TodoType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => date('Y-m-d'),
            'user_id' => User::factory(),
            'todo_type_id' => TodoType::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words('10', true),
        ];
    }
}
