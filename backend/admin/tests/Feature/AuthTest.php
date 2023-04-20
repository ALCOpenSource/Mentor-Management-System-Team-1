<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // Seed the database with the default data
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the register endpoint.
     */
    public function testRegister(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'user',
                'access_token',
            ],
        ]);
    }

    /**
     * Test the login endpoint.
     */
    public function testLogin(): void
    {
        $this->testRegister();
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@localhost',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user',
                'access_token',
            ],
        ]);
    }

    /**
     * Test the logout endpoint.
     */
    public function testLogout(): void
    {
        $this->testLogin();

        // Sanctum
        $sanctum = new Sanctum();
        $sanctum->actingAs(callStatic(User::class, 'first'));
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
        ]);
    }

    /**
     * Test the user endpoint.
     */
    public function testUser(): void
    {
        $this->testLogin();
        $response = $this->getJson('/api/auth/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);
    }

    /**
     * Test the refresh endpoint.
     */
    public function testRefresh(): void
    {
        $this->testLogin();
        $response = $this->postJson('/api/auth/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
            ],
        ]);
    }
}
