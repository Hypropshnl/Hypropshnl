<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->string('vehicle_id')->nullable();
            $table->string('vin')->nullable();
            $table->integer('insurance_status')->nullable();
            $table->text('current_condition')->nullable();
            $table->text('route')->nullable();
            $table->text('service_parts')->nullable();
            $table->integer('active_status')->nullable();
            $table->string('engine_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            //
        });
    }
}
