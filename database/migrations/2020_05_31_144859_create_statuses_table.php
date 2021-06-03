<?php

use App\Models\Complaint;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceQuotationItem;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use App\Models\VehicleInventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color_class');
            $table->string('model_type');
            $table->boolean('front_visible')->default(true);
            $table->integer('sequence');
        });

        DB::unprepared('
            CREATE TRIGGER trigger_status
            BEFORE INSERT
               ON statuses FOR EACH ROW
            BEGIN
               DECLARE sequence_t int;

               SELECT IFNULL(MAX(sequence), 0) + 1 INTO sequence_t from statuses WHERE model_type = NEW.model_type ;
               SET NEW.sequence = sequence_t;
               SET NEW.name = LOWER(NEW.name);
            END;
        ');

        $maintenanceReq = get_class(new MaintenanceRequest);
        $vehicleInventory = get_class(new VehicleInventory);
        $vehicleComplaint = get_class(new Complaint);
        $maintenanceQuote = get_class(new MaintenanceQuotation);

        // Maintenance Quote

        Status::create([
            'name' => 'Pending Quote',
            'color_class' => 'secondary',
            'model_type' => $maintenanceQuote
        ]);

        Status::create([
            'name' => 'Quoted',
            'color_class' => 'info',
            'model_type' => $maintenanceQuote
        ]);

        Status::create([
            'name' => 'Approved',
            'color_class' => 'success',
            'model_type' => $maintenanceQuote,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'Declined',
            'color_class' => 'danger',
            'model_type' => $maintenanceQuote,
            'front_visible' => false
        ]);

        // VehicleInventory

        Status::create([
            'name' => 'Available',
            'color_class' => 'success',
            'model_type' => $vehicleInventory
        ]);

        Status::create([
            'name' => 'Unavailable',
            'color_class' => 'danger',
            'model_type' => $vehicleInventory
        ]);

        Status::create([
            'name' => 'Maintenance',
            'color_class' => 'info',
            'model_type' => $vehicleInventory
        ]);

        Status::create([
            'name' => 'Pending Complaints',
            'color_class' => 'warning',
            'model_type' => $vehicleInventory
        ]);

        // VehicleComplaint

        Status::create([
            'name' => 'Pending',
            'color_class' => 'warning',
            'model_type' => $vehicleComplaint
        ]);

        Status::create([
            'name' => 'Dismissed',
            'color_class' => 'danger',
            'model_type' => $vehicleComplaint
        ]);

        Status::create([
            'name' => 'Pending Maintenance',
            'color_class' => 'info',
            'model_type' => $vehicleComplaint
        ]);

        Status::create([
            'name' => 'Resolved',
            'color_class' => 'success',
            'model_type' => $vehicleComplaint
        ]);

        // Maintenance Request
        Status::create([
            'name' => 'PENDING',
            'color_class' => 'warning',
            'model_type' => $maintenanceReq,
        ]);

        Status::create([
            'name' => 'DISMISSED',
            'color_class' => 'danger',
            'model_type' => $maintenanceReq,
        ]);

        Status::create([
            'name' => 'PENDING APPROVAL',
            'color_class' => 'info',
            'model_type' => $maintenanceReq,
        ]);

        Status::create([
            'name' => 'APPROVED',
            'color_class' => 'success',
            'model_type' => $maintenanceReq,
        ]);

        Status::create([
            'name' => 'REJECTED',
            'color_class' => 'danger',
            'model_type' => $maintenanceReq,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
        DB::unprepared('DROP TRIGGER `trigger_status`');
    }
}
