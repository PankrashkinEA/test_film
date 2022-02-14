<?php

namespace Tests\Feature;

use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FilmControllerTests extends TestCase
{
    public function testIndexReturnsDataInValidFormat()
    {
        $this->json('get', 'api/films')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'genre_id',
                            'title',
                            'description',
                            'year'
                        ]
                    ]
                ]
            );
    }

    public function testFilmIsCreatedSuccessfully()
    {

        $payload = [
            'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
            'title' => $this->faker->word(2),
            'description' => $this->faker->realText(200),
            'year' => $this->faker->year
        ];
        $this->json('post', 'api/films', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'genre_id',
                        'title',
                        'description',
                        'year'
                    ]
                ]
            );
        $this->assertDatabaseHas('films', $payload);
    }

    public function testFilmIsShownCorrectly()
    {
        $film = Film::create(
            [
                'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
                'title' => $this->faker->word(2),
                'description' => $this->faker->realText(200),
                'year' => $this->faker->year
            ]
        );

        $this->json('get', "api/films/$film->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'         => $film->id,
                        'genre_id'   => $film->genre_id,
                        'title'      => $film->title,
                        'description'=> $film->description,
                        'year'       => $film->year
                    ]
                ]
            );
    }

    public function testUpdateFilmReturnsCorrectData()
    {
        $actor = Actor::create(
            [
                'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
                'title' => $this->faker->word(2),
                'description' => $this->faker->realText(200),
                'year' => $this->faker->year
            ]
        );

        $payload = [
            'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
            'title' => $this->faker->word(2),
            'description' => $this->faker->realText(200),
            'year' => $this->faker->year
        ];

        $this->json('put', "api/actors/$actor->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'         => $actor->id,
                        'title'      => $payload['name'],
                        'genre_id'   => $payload['genre_id'],
                        'description'=> $payload['description'],
                        'year'       => $payload['year'],
                    ]
                ]
            );
    }

    public function testFilmIsDestroyed()
    {

        $filmData =
            [
                'genre_id' => $this->faker->unique(true)->randomElement(DB::table('genres')->pluck('id')),
                'title' => $this->faker->word(2),
                'description' => $this->faker->realText(200),
                'year' => $this->faker->year
            ];
        $film = Film::create(
            $filmData
        );

        $this->json('delete', "api/films/$film->id")
            ->assertNoContent();
        $this->assertDatabaseMissing('films', $filmData);
    }
}
