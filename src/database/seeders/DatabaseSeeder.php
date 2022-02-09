<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\FilmActor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Generator::create();

        $films = Film::all()->lists('id');
        $actors = Actor::all()->lists('id');
        foreach (range(1, 30) as $index)
        {
            FilmActor::create([
                'film_id' => $faker->randomElement($films),
                'actor_id' => $faker->randomElement($actors)
            ]);
        }
    }
}
