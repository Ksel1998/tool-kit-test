<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $clientRole;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientRole = UserRoles::where('name', 'client')->first();

        $this->client = User::where('role_id', $this->clientRole->id)->first();
    }

    // Проверка регистрации нового клиента
    public function testRegistration()
    {
        $newUserData = [
            'name' => 'New User',
            'email' => 'new@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $response = $this->postJson('api/register', $newUserData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user',
                'token'
            ]);
    }

    // Проверка входа в акаунт
    public function testLogin()
    {   
        $loginForm = [
            'email' => $this->client->email,
            'password' => '111'
        ];

        $response = $this->postJson('api/login', $loginForm);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    // Проверка получения данных о текущем пользователе
    public function testGetUser()
    {
        $token = JWTAuth::fromUser($this->client);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/user');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role_id'
                ]
            ]);
    }

    // Проверка выхода из акаунта
    public function testLogout()
    {
        $token = JWTAuth::fromUser($this->client);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('api/logout');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
