<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_transfer_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_whse')->nullable();
            $table->integer('from_zone')->nullable();
            $table->integer('from_bin')->nullable();
            $table->integer('location_status')->nullable();
            $table->string('custom_location')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->integer('to_whse')->nullable();
            $table->integer('to_zone')->nullable();
            $table->integer('to_bin')->nullable();
            $table->integer('return_whse')->nullable();
            $table->integer('return_zone')->nullable();
            $table->integer('return_bin')->nullable();
            $table->string('order_id')->nullable();
            $table->text('order_desc')->nullable();
            $table->text('attachment')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('order_status')->nullable();
            $table->integer('transfer_quantity')->nullable();
            $table->integer('return_quantity')->nullable();
            $table->integer('due_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_transfer_order');
    }
}
