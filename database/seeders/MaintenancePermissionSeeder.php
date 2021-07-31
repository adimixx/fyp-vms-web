<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MaintenancePermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => 'maintenance:view'
        ]);

        Permission::create([
            'name' => 'maintenance:crud'
        ]);

        Permission::create([
            'name' => 'maintenance:pending'
        ]);

        Permission::create([
            'name' => 'maintenance:pending_review'
        ]);

        Permission::create([
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
