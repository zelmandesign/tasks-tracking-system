<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiTokenServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_token_success()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        // Send a post request to create a token
        $response = $this->postJson('/api/tokens/create', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert the response status and token structure
        $response->assertStatus(201);
        $response->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_invalid_login_credentials()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        // Send a post request with wrong password
        $response = $this->postJson('/api/tokens/create', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // Assert the response status
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid login credentials']);
    }
}
