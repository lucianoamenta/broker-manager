<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesTableSeeder extends Seeder {

    public function run(): void {
        
        $role1 = Role::create(['name' => User::ROL_GOD]);
        $role2 = Role::create(['name' => User::ROL_ADMIN]);
        $role3 = Role::create(['name' => User::ROL_EMPLEADO]);
        $role4 = Role::create(['name' => User::ROL_CLIENTE]);
        $role5 = Role::create(['name' => User::ROL_BOT]);

        Permission::create(['name' => 'ver_personas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'ver_cajas'])->syncRoles([$role1, $role2, $role3, $role4]);
    }
}
