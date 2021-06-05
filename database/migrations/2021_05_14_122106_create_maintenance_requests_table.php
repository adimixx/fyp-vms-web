<?php

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
            $table->string('code');
            $table->unsignedBigInteger('vehicle_inventory_id');
            $table->unsignedBigInteger('maintenance_category_id');
            $table->unsignedBigInteger('maintenance_unit_id');
            $table->unsignedBigInteger('complaint_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('detail');
            $table->unsignedBigInteger('status_id');
            $table->string('status_note')->nullable();
            $table->foreign('vehicle_inventory_id')->references('id')->on('vehicle_inventories');
            $table->foreign('maintenance_category_id')->references('id')->on('maintenance_categories');
            $table->foreign('maintenance_unit_id')->references('id')->on('maintenance_units');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('complaint_id')->references('id')->on('complaints');
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
        Schema::dropIfExists('maintenance_requests');
    }
}
