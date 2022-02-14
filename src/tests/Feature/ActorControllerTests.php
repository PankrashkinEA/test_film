<?php

namespace Tests\Feature;

use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ActorControllerTests extends TestCase
{

    public function testIndexReturnsDataInValidFormat()
    {
        $this->json('get', 'api/actors')
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

    public function testActorIsCreatedSuccessfully()
    {

        $payload = [
            'name' => $this->faker->name,
        ];
        $this->json('post', 'api/actors', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name'
                    ]
                ]
            );
        $this->assertDatabaseHas('actors', $payload);
    }

    public function testActorIsShownCorrectly()
    {
        $actor = Actor::create(
            [
                'name' => $this->faker->name,
            ]
        );

        $this->json('get', "api/actors/$actor->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'         => $actor->id,
                        'name'       => $actor->first_name
                    ]
                ]
            );
    }

    public function testUpdateActorReturnsCorrectData()
    {
        $actor = Actor::create(
            [
                'name' => $this->faker->name
            ]
        );

        $payload = [
            'name' => $this->faker->name,
        ];

        $this->json('put', "api/actors/$actor->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id'         => $actor->id,
                        'name' => $payload['name'],
                    ]
                ]
            );
    }

    public function testActorIsDestroyed()
    {

        $actorData =
            [
                'name' => $this->faker->name
            ];
        $actor = Actor::create(
            $actorData
        );

        $this->json('delete', "api/actors/$actor->id")
            ->assertNoContent();
        $this->assertDatabaseMissing('actors', $actorData);
    }
}
