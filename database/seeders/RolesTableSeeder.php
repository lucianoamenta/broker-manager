<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $role1 = Role::firstOrCreate(['name' => User::ROL_GOD]);
        $role2 = Role::firstOrCreate(['name' => User::ROL_ADMIN]);
        $role3 = Role::firstOrCreate(['name' => User::ROL_EMPLEADO]);
        $role4 = Role::firstOrCreate(['name' => User::ROL_CLIENTE]);
        $role5 = Role::firstOrCreate(['name' => User::ROL_BOT]);
        $role6 = Role::firstOrCreate(['name' => User::ROL_ZONE_MANAGER]);
        $role7 = Role::firstOrCreate(['name' => User::ROL_DEPARTMENT_HEAD]);
        $role8 = Role::firstOrCreate(['name' => User::ROL_CASHIER]);
        $role9 = Role::firstOrCreate(['name' => User::ROL_COLLECTOR]);

        Permission::firstOrCreate(['name' => 'ver_personas'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'ver_cajas'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
    }
}
