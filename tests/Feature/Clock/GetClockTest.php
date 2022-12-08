<?php
declare(strict_types=1);
namespace Tests\Feature\Clock;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetClockTest extends TestCase
{
    public function testsGetUserClocks(): void
    {
        $user = User::factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'time_difference_seconds' => fake()->numberBetween(-500,500),
        ];

        // no clocks should exist before they're created
        $this->json('GET', '/api/clock', [], $headers)
            ->assertStatus(404);

        // create clocks
        $this->json('POST', '/api/clock', $payload, $headers);

        // clocks should exist
        $this->json('GET', '/api/clock', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'display_time',
                    'time_difference_seconds',
                ],
            ]);
    }

}
