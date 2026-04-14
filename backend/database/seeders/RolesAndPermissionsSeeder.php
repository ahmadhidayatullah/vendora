<?php

namespace Database\Seeders;

use App\Enums\User\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (UserRole::values() as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        
        // $permissions = [
        //     'manage users',
        //     'manage products',
        //     'create order'
        // ];

        // foreach ($permissions as $perm) {
        //     Permission::firstOrCreate(['name' => $perm]);
        // }

        // $roles = [
        //     'superadmin',
        //     'vendor',
        //     'customer'
        // ];

        // foreach ($roles as $roleName) {
        //     $role = Role::firstOrCreate(['name' => $roleName]);

        //     switch ($roleName) {
        //         case 'superadmin':
        //             $role->givePermissionTo(Permission::all());
        //             break;
        //         case 'vendor':
        //             $role->givePermissionTo([
        //                 'manage products',
        //                 'create order',
        //             ]);
        //             break;
        //         case 'customer':
        //             $role->givePermissionTo([
        //                 'create order',
        //             ]);
        //             break;
        //     }
        // }
    }
}