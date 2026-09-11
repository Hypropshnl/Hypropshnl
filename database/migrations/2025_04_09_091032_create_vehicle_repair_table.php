<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_repair', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id');
            $table->integer('dept_id');
            $table->integer('project_id');
            $table->text('fault_desc');
            $table->string('admin_verification');
            $table->date('incident_date');
            $table->text('docs');

            $table->text('approval_json')->nullable();
            $table->text('approval_level')->nullable();
            $table->text('approval_user')->nullable();
            $table->text('approved_users')->nullable();
            $table->text('edit_request')->nullable();
            $table->integer('approval_id')->nullable();
            $table->integer('complete_status')->nullable();
            $table->integer('deny_user')->nullable();
            $table->text('deny_reason')->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('vehicle_repair');
    }
}
