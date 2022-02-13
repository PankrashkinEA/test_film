<?php

namespace Database\Seeders;

use App\Models\ActorFilm;
use Illuminate\Database\Seeder;

class ActorFilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActorFilm::factory(20)->create();
    }
}
