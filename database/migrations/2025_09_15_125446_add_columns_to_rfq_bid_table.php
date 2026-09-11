<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToRfqBidTable extends Migration
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
            $table->text('custom_message')->nullable();
            $table->text('vendor_mails')->nullable();
            $table->integer('submit_status')->default(1);
            $table->integer('custom_status')->nullable();
            $table->integer('selected_status')->nullable();
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
