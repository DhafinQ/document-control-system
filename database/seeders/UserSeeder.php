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
                "name" => "admin",
                "email" => "admin@gmail.com",
                "password" => bcrypt("password"),
                "role" => "admin"
            ],
            [
                "name" => "reviewer",
                "email" => "reviewer@gmail.com",
                "password" => bcrypt("password"),
                "role" => "Reviewer"
            ],
            [
                "name" => "staff",
                "email" => "staff@gmail.com",
                "password" => bcrypt("password"),
                "role" => "Staf"
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
