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
        $roles = [];
        foreach (User::getAvailableRoles() as $roleName) {
            $roles[$roleName] = Role::firstOrCreate(['name' => $roleName]);
        }

        Permission::firstOrCreate(['name' => 'ver_personas'])->syncRoles([
            $roles[User::ROL_GOD],
            $roles[User::ROL_ADMIN],
            $roles[User::ROL_ADMIN_ORGANIZATION],
        ]);

        Permission::firstOrCreate(['name' => 'ver_cajas'])->syncRoles([
            $roles[User::ROL_GOD],
            $roles[User::ROL_ADMIN],
            $roles[User::ROL_EMPLEADO],
            $roles[User::ROL_TESORERO],
            $roles[User::ROL_ADMIN_OFFICE],
            $roles[User::ROL_CASHIER],
        ]);
    }
}
