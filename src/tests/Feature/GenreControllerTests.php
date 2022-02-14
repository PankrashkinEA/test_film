<?php

namespace Tests\Feature;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GenreControllerTests extends TestCase
{
    public function testIndexReturnsDataInValidFormat()
    {
        $this->json('get', 'api/genres')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            );
    }

    public function testGenreIsCreatedSuccessfully()
    {

        $payload = [
            'name' => $this->faker->name,
        ];
        $this->json('post', 'api/genres', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name'
                    ]
                ]
            );
        $this->assertDatabaseHas('genres', $payload);
    }

    public function testGenreIsShownCorrectly()
    {
        $genre = Genre::create(
            [
                'name' => $this->faker->name,
            ]
        );

        $this->json('get', "api/genres/$genre->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'         => $genre->id,
                        'name'       => $genre->first_name
                    ]
                ]
            );
    }

    public function testUpdateGenreReturnsCorrectData()
    {
        $genre = Genre::create(
            [
                'name' => $this->faker->name
            ]
        );

        $payload = [
            'name' => $this->faker->name,
        ];

        $this->json('put', "api/genres/$genre->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'   => $genre->id,
                        'name' => $payload['name'],
                    ]
                ]
            );
    }

    public function testGenreIsDestroyed()
    {

        $genreData =
            [
                'name' => $this->faker->name
            ];
        $genre = Genre::create(
            $genreData
        );

        $this->json('delete', "api/genres/$genre->id")
            ->assertNoContent();
        $this->assertDatabaseMissing('genres', $genreData);
    }
}
