<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ComplaintPermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'complaint:crud_self'
        ]);

        Permission::firstOrCreate([
            'name' => 'complaint:crud_all'
        ]);

        $admin = Role::findOrCreate('admin');
        $staff = Role::findOrCreate('staff');
        $management = Role::findOrCreate('management');
        $committee = Role::findOrCreate('committee');

        // mP = maintenance Permission
        $mP = collect(['complaint:crud_self', 'complaint:crud_all']);

        $admin->givePermissionTo($mP);
        $management->givePermissionTo($mP);
        $staff->givePermissionTo($mP->except([1]));
    }
}
