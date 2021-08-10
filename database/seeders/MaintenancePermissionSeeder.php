<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MaintenancePermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'maintenance:view'
        ]);

        Permission::firstOrCreate([
            'name' => 'maintenance:crud'
        ]);

        Permission::firstOrCreate([
            'name' => 'maintenance:pending'
        ]);

        Permission::firstOrCreate([
            'name' => 'maintenance:crud_pending_review'
        ]);

        $admin = Role::findOrCreate('admin');
        $staff = Role::findOrCreate('staff');
        $management = Role::findOrCreate('management');
        $committee = Role::findOrCreate('committee');

        // mP = maintenance Permission
        $mP = collect(['maintenance:view', 'maintenance:crud', 'maintenance:pending', 'maintenance:crud_pending_review']);

        $admin->givePermissionTo($mP);
        $management->givePermissionTo($mP->except([3]));
        $committee->givePermissionTo($mP->except([1,2]));
    }
}
