<?php
declare(strict_types=1);
namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin(): void
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400)
            ->assertJson([
                "error" => "The email field is required. (and 1 more error)",
                "code" => 400,
                "data" => []
            ]);
    }


    public function testUserLoginsSuccessfully(): void
    {
        $user =  User::factory(User::class)->create([
            'email' => 'testuser@autovex.fi',
            'password' => bcrypt('strongPassword123'),
        ]);

        $payload = ['email' => 'testuser@autovex.fi', 'password' => 'strongPassword123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
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
}
