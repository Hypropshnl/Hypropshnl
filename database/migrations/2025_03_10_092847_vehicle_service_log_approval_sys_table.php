<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VehicleServiceLogApprovalSysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_service_log_approval_sys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approval_name')->nullable();
            $table->longText('level_users')->nullable();
            $table->longText('levels')->nullable();
            $table->longText('users')->nullable();
            $table->longText('json_display')->nullable();
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
        Schema::dropIfExists('vehicle_service_log_approval_sys');
    }
}
