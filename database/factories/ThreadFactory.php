<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->text(30),
            'body'          => $this->faker->paragraph(3, true),
            'slug'          => $this->faker->unique()->slug,
            'author_id'     => rand(1,3),
            'category_id'   => rand(1,7),
        ];
    }
}
