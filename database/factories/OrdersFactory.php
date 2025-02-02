<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Orders::class;

    public function definition(): array
    {
        // Создаем тестовые заявки
        $adminId = UserRoles::where('name', 'admin')->value('id');

        return [
            'order' => $this->faker->paragraph(2),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => User::whereNot('role_id', $adminId)->inRandomOrder()->value('id'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
