<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_bid', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rfq_id')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('due_date')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('rfq_bid');
    }
}
