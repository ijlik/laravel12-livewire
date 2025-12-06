<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'user' => [
                'show profile'
            ],
            'superadmin' => [
                'create user'
            ]
        ];

        foreach ($map as $role => $permissions) {
            $r = Role::create(['name' => $role]);
            foreach ($permissions as $permission) {
                $p = Permission::create(['name' => $permission]);
                $r->givePermissionTo($p);
            }
        }
    }
}
