<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuário administrador
        User::UpdateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Usuário comum
        User::UpdateOrCreate(['email' => 'user@example.com'], [
            'name' => 'User',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);
    }
}
