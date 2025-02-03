<?php

// namespace Tests\Unit\Http\Controllers\Admin;
namespace Tests\Unit;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminUserControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $adminRole;
    protected $clientRole;
    protected $admin;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = UserRoles::where('name', 'admin')->first();
        $this->clientRole = UserRoles::where('name', 'client')->first();

        $this->admin = User::where('role_id', $this->adminRole->id)->first();
        $this->client = User::where('role_id', $this->clientRole->id)->first();
    }

    // Проверка получения всех пользователей
    public function testGetAllUsers()
    {
        $ordersCount = User::count();
        $token = JWTAuth::fromUser($this->admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/admin/get_all_users');

        $response->assertStatus(200)
            ->assertJsonCount($ordersCount, 'allUsers')
            ->assertJsonStructure([
                'allUsers' => [
                    '*' => [
                        'id', 
                        'name', 
                        'email', 
                        'role_id'
                    ]
                ]
            ]);
    }

    // Проверка обновления пользователя
    public function testUpdateUser()
    {
        $token = JWTAuth::fromUser($this->admin);

        $newUserData = [
            'name' => 'New Name',
            'email' => 'newEmail@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->patchJson('api/admin/update_user/' . $this->client->id, $newUserData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'newData' => [
                    'id',
                    'name',
                    'email',
                    'role_id'
                ]
            ]);
    }

    // Проверка удаления пользователя
    public function testDeleteUser()
    {
        $token = JWTAuth::fromUser($this->admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson('api/admin/delete_user/' . $this->client->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status'
            ]);
    }
}
