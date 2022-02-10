<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
            'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
            'title' => $this->faker->word(2),
            'description' => $this->faker->realText(200),
            'year' => $this->faker->year
        ];
    }
}
