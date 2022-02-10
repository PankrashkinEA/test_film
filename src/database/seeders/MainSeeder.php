<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\ActorFilm;
use App\Models\Genre;
use App\Models\Film;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actor::factory(10)->create();
        Genre::factory(3)->create();
        Film::factory(10)->create();
        ActorFilm::factory(50)->create();

    }
}
