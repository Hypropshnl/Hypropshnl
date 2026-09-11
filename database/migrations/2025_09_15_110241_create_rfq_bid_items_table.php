<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqBidItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_bid_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rfq_id');
            $table->integer('rfq_bid_id');
            $table->integer('item_id')->nullable();
            $table->string('item_desc')->nullable();
            $table->integer('account_id')->nullable();
            $table->string('rate');
            $table->integer('amount');
            $table->integer('submit_status')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('rfq_bid_items');
    }
}
