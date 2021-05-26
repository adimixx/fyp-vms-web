<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code');
            $table->unsignedBigInteger('vehicle_inventory_id');
            $table->unsignedBigInteger('service_category_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status');
            $table->string('status_note')->nullable();
            $table->foreign('vehicle_inventory_id')->references('id')->on('vehicle_inventories');
            $table->foreign('service_category_id')->references('id')->on('service_categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
