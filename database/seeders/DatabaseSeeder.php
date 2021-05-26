<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceVendor;
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

        ServiceCategory::create([
            'name' => 'PENGHAWA DINGIN'
        ]);

        ServiceCategory::create([
            'name' => 'PEMBAIKAN MEKANIKAL DAN ELEKTRIKAL'
        ]);

        ServiceCategory::create([
            'name' => '3M'
        ]);

        ServiceCategory::create([
            'name' => 'TAYAR DAN BATERI'
        ]);

        ServiceCategory::create([
            'name' => 'SERVIS BERKALA'
        ]);

        ServiceCategory::create([
            'name' => 'JIT'
        ]);

        ServiceVendor::create([
            'name' => 'Sam Hin Motors Enterprise Sdn. Bhd.'
        ]);

        ServiceVendor::create([
            'name' => 'CMB Enterprise'
        ]);

        ServiceVendor::create([
            'name' => 'Perkhidmatan Tayar Serantau Desa Sdn. Bhd.'
        ]);

        ServiceVendor::create([
            'name' => 'COMMECTS (M) Sdn. Bhd'
        ]);

        ServiceVendor::create([
            'name' => 'HAFA-X Auto Centers Sdn Bhd'
        ]);

        ServiceVendor::create([
            'name' => 'ABD  Cahaya Enterprise'
        ]);

        ServiceVendor::create([
            'name' => 'Noorfere Enterprise'
        ]);

        ServiceVendor::create([
            'name' => 'Tan Chong Express Sdn. Bhd.'
        ]);

        ServiceVendor::create([
            'name' => 'HIEWA AUTO GALLERY'
        ]);

        ServiceVendor::create([
            'name' => 'Peringgit Auto Sdn. Bhd.'
        ]);
    }
}
