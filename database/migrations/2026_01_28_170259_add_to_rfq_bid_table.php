<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToRfqBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_bid', function (Blueprint $table) {
            //
            $table->string('sub_total')->nullable();
            $table->string('discount')->default(0);
            $table->string('tax')->default(0);
            $table->string('discount_perct')->default(0);
            $table->string('tax_perct')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfq_bid', function (Blueprint $table) {
            //
        });
    }
}
