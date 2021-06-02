<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_quotations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('maintenance_request_id');
            $table->unsignedBigInteger('maintenance_vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date_request');
            $table->date('date_invoice')->nullable();
            $table->bigInteger('cost_total')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->string('file_directory')->nullable();
            $table->foreign('maintenance_request_id')->references('id')->on('maintenance_requests');
            $table->foreign('maintenance_vendor_id')->references('id')->on('maintenance_vendors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_quotations');
    }
}
