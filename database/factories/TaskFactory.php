<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TaskStatus;
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
        return [
            'title' => "Задача: ". $this->faker->realText(mt_rand(25, 50)),
            'description'  =>$this->faker->realText(mt_rand(150, 400)),
            'deadline' => $this->faker->dateTimeBetween('-1 week', '+2 week'),
            'length' => $this->faker->numberBetween(0, 10000),
            'project_id' => Project::inRandomOrder()->first()->id,
            'task_status_id' => TaskStatus::inRandomOrder()->first()->id
        ];
    }
}
