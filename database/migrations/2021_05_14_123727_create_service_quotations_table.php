<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_quotations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('service_request_id');
            $table->unsignedBigInteger('service_vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('cost_total');
            $table->json('cost_particulars');
            $table->boolean('is_approved')->nullable();
            $table->foreign('service_request_id')->references('id')->on('service_requests');
            $table->foreign('service_vendor_id')->references('id')->on('service_vendors');
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
        Schema::dropIfExists('service_quotations');
    }
}
