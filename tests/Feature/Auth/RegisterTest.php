<?php
declare(strict_types=1);
namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully(): void
    {
        $payload = [
            'name' => 'Dolls',
            'email' => 'testuser@autovex.fi',
            'password' => 'strongPassword123',
            'password_confirmation' => 'strongPassword123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }

    public function testsRequiresPasswordEmailAndName(): void
    {
        $this->json('post', '/api/register')
            ->assertStatus(400)
            ->assertJson([
                "error" => "The name field is required. (and 2 more errors)",
                "code" => 400,
                "data" => []
            ]);
    }

    public function testsRequirePasswordConfirmation(): void
    {
        $payload = [
            'name' => 'Dolls',
            'email' => 'testuser@autovex.fi',
            'password' => 'strongPassword123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(400)
            ->assertJson([
                "error" => "The password confirmation does not match.",
                "code" => 400,
                "data" => []
            ]);
    }
}
