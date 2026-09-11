<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToInventoryAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_assign', function (Blueprint $table) {
            //
            $table->integer('store_id')->nullable();
            $table->string('whse_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->integer('bin_id')->nullable();
            $table->string('whse_status')->nullable();
            $table->integer('deduct_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_assign', function (Blueprint $table) {
            //
        });
    }
}
