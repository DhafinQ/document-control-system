<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Itstructure\LaRbac\Models\{Role, Permission};

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Custom permissions
        $permissions = [
            ['slug' => 'manage-users', 'name' => 'Manage Users', 'description' => 'Permission to manage users'],
            ['slug' => 'manage-documents', 'name' => 'Manage Documents', 'description' => 'Permission to manage documents'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }

        // Custom roles
        $roles = [
            'Admin' => ['manage-users', 'manage-documents'],
            'Reviewer' => ['manage-documents'],
            'Staff' => [],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::updateOrCreate(
                ['slug' => strtolower($roleName)],
                ['name' => $roleName, 'description' => "{$roleName} role"]
            );

            $permissionIds = Permission::whereIn('slug', $rolePermissions)->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    }
}
