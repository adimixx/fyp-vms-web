<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::create([
            'name'=>'admin'
        ]);

        Role::create([
            'name'=>'staff'
        ]);

        $admin = User::create([
            'name'=>'Admin',
            'email'=>'admin@vms.psm',
            'password'=> Hash::make('admin')
        ]);

        $admin->assignRole('admin');

        VehicleCategory::create([
            'name' => '4X4 & 4X2'
        ]);

        VehicleCategory::create([
            'name' => 'BAS & COACH'
        ]);

        VehicleCategory::create([
            'name' => 'KERETA'
        ]);

        VehicleCategory::create([
            'name' => 'LORI'
        ]);

        VehicleCategory::create([
            'name' => 'MOTORSIKAL'
        ]);

        VehicleCategory::create([
            'name' => 'MPV'
        ]);

        VehicleCategory::create([
            'name' => 'SUV'
        ]);

        VehicleCategory::create([
            'name' => 'VAN'
        ]);

        VehicleCategory::create([
            'name' => 'STOK'
        ]);
    }
}
