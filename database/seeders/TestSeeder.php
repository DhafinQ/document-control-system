<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Roles::create([
            'name' => 'Admin'
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => $role->id,
            'password' => Hash::make('admin123'),
        ]);

        Category::insert([
            ['name' => 'SOP'],
            ['name' => 'MOU']
        ]);
    }
}
