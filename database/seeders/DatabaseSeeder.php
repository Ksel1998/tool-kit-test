<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создание стандартных ролей
        $this->call(UserRolesSeeder::class);

        // Создание тестовых пользователей
        $this->call(UserSeeder::class);

        // // Создаем тестовые заявки
        $this->call(OrdersSeeder::class);
    }
}
