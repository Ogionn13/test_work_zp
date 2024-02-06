<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "Проект: ". $this->faker->realText(mt_rand(25, 50)),
            'description'  =>$this->faker->realText(mt_rand(150, 400)),
            'deadline' => $this->faker->dateTimeBetween('-3 week', '+6 week'),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id
        ];
    }
}
