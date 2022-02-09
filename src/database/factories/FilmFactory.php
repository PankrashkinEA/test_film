<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'genre_id' => rand(1,3),
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->realText(200),
            'year' => $this->faker->year
        ];
    }
}
