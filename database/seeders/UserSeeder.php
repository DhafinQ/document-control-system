<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Itstructure\LaRbac\Models\Role; // Ubah namespace ke LaRbac

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => "password",
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->attach($adminRole->id);
    }
}
