<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Создаем пользователя с ролью 'admin'
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_role' => 'admin',
        ]);

        // Генерируем токен Sanctum для пользователя
        $token = $admin->createToken('token-name')->plainTextToken;

        // Выводим токен для информации (можно удалить в production)
        echo "Admin Token: $token\n";
    }
}
