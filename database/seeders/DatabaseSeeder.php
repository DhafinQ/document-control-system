<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Itstructure\Rbac\Models\Role;
use Itstructure\Rbac\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            LaRbacDatabaseSeeder::class, // Panggil seeder di sini
            UserSeeder::class, // Panggil seeder di sini

        ]);
    }
}
