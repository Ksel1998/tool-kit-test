<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание стандартных ролей
        DB::table('user_roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'name' => 'client',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
