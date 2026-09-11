<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToInventoryRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_record', function (Blueprint $table) {
            //
            $table->integer('store_id');
            $table->string('whse_id');
            $table->integer('zone_id');
            $table->integer('bin_id');
            $table->string('whse_status');
            $table->integer('active_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_record', function (Blueprint $table) {
            //
        });
    }
}
