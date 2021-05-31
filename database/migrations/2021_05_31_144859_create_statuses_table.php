<?php

use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        });

        $maintenanceReq = get_class(MaintenanceRequest::first());

        Status::create([
            'name' => 'Pending Quote',
            'color_class' => 'info',
            'model_type' => $maintenanceReq
        ]);

        Status::create([
            'name' => 'Quoted',
            'color_class' => 'info',
            'model_type' => $maintenanceReq
        ]);

        Status::create([
            'name' => 'Approved',
            'color_class' => 'success',
            'model_type' => $maintenanceReq,
            'front_visible' => false
        ]);

        Status::create([
            'name' => 'Declined',
            'color_class' => 'danger',
            'front_visible' => false
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
    }
}
