<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'Xw0mU@example.com',
            'phone' => '081234567890',
            'name' => 'Admin',
            'password' => Hash::make('pastibisa'),
            'remember_token' => Str::random(10),
        ]);

        $response = $this->json('post', 'api/login', [
            'username' => $user->username,
            'password' => 'pastibisa',
        ]);

        // dd($response);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Login berhasil.',
            ]);
    }

    /** @test */
    public function it_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'username' => $user->username,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Kredensial tidak sah.',
            ]);
    }

    /** @test */
    public function it_can_logout_authenticated_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('API Token')->plainTextToken;

        $response = $this->withToken($token)->postJson(route('logout'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Berhasil logout.',
            ]);
    }
}
