<?php

namespace Database\Seeders;

use App\Models\MaintenanceCategory;
use App\Models\MaintenanceUnit;
use App\Models\MaintenanceVendor;
use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'staff'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@vms.psm',
            'password' => Hash::make('admin')
        ]);

        $admin->assignRole([1]);

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

        MaintenanceCategory::create([
            'name' => 'PENGHAWA DINGIN'
        ]);

        MaintenanceCategory::create([
            'name' => 'PEMBAIKAN MEKANIKAL DAN ELEKTRIKAL'
        ]);

        MaintenanceCategory::create([
            'name' => '3M'
        ]);

        MaintenanceCategory::create([
            'name' => 'TAYAR DAN BATERI'
        ]);

        MaintenanceCategory::create([
            'name' => 'SERVIS BERKALA'
        ]);

        MaintenanceCategory::create([
            'name' => 'JIT'
        ]);

        MaintenanceVendor::create([
            'name' => 'Sam Hin Motors Enterprise Sdn. Bhd.'
        ]);

        MaintenanceVendor::create([
            'name' => 'CMB Enterprise'
        ]);

        MaintenanceVendor::create([
            'name' => 'Perkhidmatan Tayar Serantau Desa Sdn. Bhd.'
        ]);

        MaintenanceVendor::create([
            'name' => 'COMMECTS (M) Sdn. Bhd'
        ]);

        MaintenanceVendor::create([
            'name' => 'HAFA-X Auto Centers Sdn Bhd'
        ]);

        MaintenanceVendor::create([
            'name' => 'ABD  Cahaya Enterprise'
        ]);

        MaintenanceVendor::create([
            'name' => 'Noorfere Enterprise'
        ]);

        MaintenanceVendor::create([
            'name' => 'Tan Chong Express Sdn. Bhd.'
        ]);

        MaintenanceVendor::create([
            'name' => 'HIEWA AUTO GALLERY'
        ]);

        MaintenanceVendor::create([
            'name' => 'Peringgit Auto Sdn. Bhd.'
        ]);

        MaintenanceUnit::create([
            'name' => 'UNIT BAS DAN LORI',
            'code' => 'UBL'
        ]);

        MaintenanceUnit::create([
            'name' => 'UNIT KERETA DAN VAN',
            'code' => 'UKV'
        ]);

        MaintenanceUnit::create([
            'name' => 'UNIT MOTOR DAN PEMBAIKAN UMUM',
            'code' => 'UMM'
        ]);

        // Execute SQL Script Import
        $sqlPath = 'database/scripts/script_1.sql';
        DB::unprepared(file_get_contents($sqlPath));
        $this->command->info('SQL Script (1) Executed');
    }
}
