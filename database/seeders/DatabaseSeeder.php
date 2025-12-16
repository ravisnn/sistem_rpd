<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
    // }

    public function run(): void
    {
        $this->call([
            AkunSeeder::class,
            UraianSeeder::class,
            KegiatanSeeder::class,
            OutputSeeder::class,
        ]);
    if (Schema::hasTable('users')) {
            \App\Models\User::updateOrCreate([
                'username' => 'admin'
            ], [
                'name' => 'admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]);
            \App\Models\User::updateOrCreate([
                'username' => 'user'
            ], [
                'name' => 'user',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]);
        }
    }
}
