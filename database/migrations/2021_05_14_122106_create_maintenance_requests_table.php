<?php

use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('vehicle_inventory_id');
            $table->unsignedBigInteger('maintenance_category_id');
            $table->unsignedBigInteger('maintenance_unit_id');
            $table->unsignedBigInteger('complaint_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('detail');
            $table->unsignedBigInteger('status_id');
            $table->string('status_note')->nullable();
            $table->string('finalize_note')->nullable();
            $table->binary('finalize_file')->nullable();
            $table->foreign('vehicle_inventory_id')->references('id')->on('vehicle_inventories');
            $table->foreign('maintenance_category_id')->references('id')->on('maintenance_categories');
            $table->foreign('maintenance_unit_id')->references('id')->on('maintenance_units');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        $maintenanceReq = get_class(new MaintenanceRequest);

        // Maintenance Request
        Status::create([
            'name' => 'PENDING',
            'color_class' => 'warning',
            'model_type' => $maintenanceReq,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'DISMISSED',
            'color_class' => 'secondary',
            'model_type' => $maintenanceReq,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'PENDING APPROVAL',
            'color_class' => 'info',
            'model_type' => $maintenanceReq,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'COMPLETED',
            'color_class' => 'success',
            'model_type' => $maintenanceReq,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'APPROVED',
            'color_class' => 'primary',
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
        Schema::dropIfExists('maintenance_requests');
    }
}
