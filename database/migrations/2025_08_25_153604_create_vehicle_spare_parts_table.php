<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_spare_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id')->nullable();
            $table->string('name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('location')->nullable();
            $table->integer('active_status')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('vehicle_spare_parts');
    }
}
