<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );
        User::updateOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]
        );
    }
}
