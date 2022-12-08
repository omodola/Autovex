<?php
declare(strict_types=1);
namespace Tests\Feature\Clock;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateClockTest extends TestCase
{
    public function testsClocksAreCreatedCorrectly(): void
    {
        $user = User::factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'time_difference_seconds' => fake()->numberBetween(-500,500),
        ];

        $this->json('POST', '/api/clock', $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'display_time',
                    'time_difference_seconds',
                ],
            ]);
    }

    public function testsClocksCreationRequireTimeDifference(): void
    {
        $user = User::factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [];

        $this->json('POST', '/api/clock', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "error" => "The time difference seconds field is required.",
                "code" => 400,
                "data" => []
            ]);
    }
}
