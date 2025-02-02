<?php

namespace Database\Seeders;

use App\Models\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание стандартного администратора
        DB::table('users')->insert([
            [
                'name' => 'administrator',
                'email' => 'admin@mail.com',
                'password' => bcrypt('123'),
                'role_id' => UserRoles::where('name', 'admin')->value('id'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Создаем тестовых клиентов
        User::factory(5)->create();
    }
}
