<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('item');
            $table->integer('quantity')->min(1);
            $table->integer('price')->min(1);
            $table->integer('subtotal')->min(1);
            $table->unsignedBigInteger('maintenance_quotation_id');
            $table->foreign('maintenance_quotation_id')->references('id')->on('maintenance_quotations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_quotation_items');
    }
}
