<?php

namespace Tests\Unit;

use App\Models\Orders;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\UploadedFile;

class AdminOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $adminRole;
    protected $clientRole;
    protected $admin;
    protected $client;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = UserRoles::where('name', 'admin')->first();
        $this->clientRole = UserRoles::where('name', 'client')->first();

        $this->admin = User::where('role_id', $this->adminRole->id)->first();
        $this->client = User::where('role_id', $this->clientRole->id)->first();
        $this->order = Orders::where('user_id', $this->client->id)->first();
    }

    // Проверка получения всех заявок
    public function testGetAllOrders()
    {
        $ordersCount = Orders::count();
        $token = JWTAuth::fromUser($this->admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/admin/get_orders');
        
        $response->assertStatus(200)
            ->assertJsonCount($ordersCount, 'orders')
            ->assertJsonStructure([
                'orders' => [
                    '*' => [
                        'id',
                        'order',
                        'address',
                        'phone',
                        'user_id'
                    ]
                ]
            ]);
    }

    // Проверка получения заявок конкретного пользователя
    public function testGetOrder()
    {
        $ordersCount = Orders::where('user_id', $this->client->id)->count();
        $token = JWTAuth::fromUser($this->admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/admin/get_orders/' . $this->client->id);

        $response->assertStatus(200)
            ->assertJsonCount($ordersCount, 'orders')
            ->assertJsonStructure([
                'orders' => [
                    '*' => [
                        'id',
                        'order',
                        'address',
                        'phone',
                        'user_id'
                    ]
                ]
            ]);
    }

    // Проверка обновления заявки
    public function testUpdateOrder()
    {
        $token = JWTAuth::fromUser($this->admin);

        $file = UploadedFile::fake()->image('test.jpg');

        $newOrderData = [
            'order' => 'New order',
            'address' => 'new address',
            'phone' => 'new phone',
            'files' => [
                $file
            ]
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('api/admin/update_order/' . $this->order->id, $newOrderData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'newData' => [
                    'id',
                    'order',
                    'address',
                    'phone',
                    'user_id'
                ]
            ]);
    }

    // Проверка удаления заявки
    public function testDeleteOrder()
    {
        $token = JWTAuth::fromUser($this->admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson('api/admin/delete_order/' . $this->order->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status'
            ]);
    }
}
