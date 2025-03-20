<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// إنشاء صلاحية
        $permission_booked = Permission::create(['name' => 'Booked Property']);

// إنشاء دور
        $role_admin = Role::create(['name' => 'customer']);
        $role_admin->givePermissionTo($permission_booked);
        $user = User::find(1);
        $user->assignRole($role_admin);

    }
}
