<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Itstructure\LaRbac\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "password" => bcrypt("password"),
                "role" => "Administrator"
            ],
            [
                "name" => "Reviewer",
                "email" => "reviewer@gmail.com",
                "password" => bcrypt("password"),
                "role" => "Reviewer"
            ],
            [
                "name" => "Staff",
                "email" => "staff@gmail.com",
                "password" => bcrypt("password"),
                "role" => "Staff"
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }
        }
    }
}
