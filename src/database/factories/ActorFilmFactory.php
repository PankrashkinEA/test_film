<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ActorFilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'film_id' => $this->faker->unique(true)->randomElement(DB::table('films')->pluck('id')),
            'actor_id' => $this->faker->unique(true)->randomElement(DB::table('actors')->pluck('id'))
        ];
    }
}
