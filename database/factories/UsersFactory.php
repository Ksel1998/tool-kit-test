<?php

namespace Database\Factories;

use App\Models\UserRoles;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Users::class;

    public function definition(): array
    {
        // Создаем тестовых клиентов
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('111'),
            'role_id' => UserRoles::where('name', 'client')->value('id'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
