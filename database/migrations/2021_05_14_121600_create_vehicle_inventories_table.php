<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_inventories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('vehicle_catalog_id');
            $table->unsignedBigInteger('status_id');
            $table->string('reg_no');
            $table->bigInteger('mileage')->nullable();
            $table->date('last_service_date')->nullable();
            $table->bigInteger('next_service_mileage')->nullable();
            $table->date('next_service_date')->nullable();
            $table->foreign('vehicle_catalog_id')->references('id')->on('vehicle_catalogs');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_inventories');
    }
}
