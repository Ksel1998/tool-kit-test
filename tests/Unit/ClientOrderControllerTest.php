<?php

namespace Tests\Unit;

use App\Models\Orders;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\UploadedFile;

class ClientOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $clientRole;
    protected $client;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientRole = UserRoles::where('name', 'client')->first();

        $this->client = User::where('role_id', $this->clientRole->id)->first();
        $this->order = Orders::where('user_id', $this->client->id)->first();
    }

    // Проверка получения всех заявок пользователем
    public function testGetAllOrders()
    {
        $ordersCount = Orders::where('user_id', $this->client->id)->count();
        $token = JWTAuth::fromUser($this->client);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/client/get_orders');

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

    // Проверка получения конкретной заявки
    public function testGetOrder()
    {
        $token = JWTAuth::fromUser($this->client);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('api/client/get_orders/' . $this->order->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'orders' => [
                    'id',
                    'order',
                    'address',
                    'phone',
                    'user_id'
                ]
            ]);
    }

    // Проверка добавления новой заявки пользователем
    public function testAddOrder()
    {
        $token = JWTAuth::fromUser($this->client);

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
            ->postJson('api/client/add_order', $newOrderData);

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

    // Проверка обновления заявки пользователем
    public function testUpdateOrder()
    {
        $token = JWTAuth::fromUser($this->client);

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
            ->postJson('api/client/update_order/' . $this->order->id, $newOrderData);

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

    public function testDeleteOrder()
    {
        $token = JWTAuth::fromUser($this->client);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson('api/client/delete_order/' . $this->order->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status'
            ]);
    }
}
