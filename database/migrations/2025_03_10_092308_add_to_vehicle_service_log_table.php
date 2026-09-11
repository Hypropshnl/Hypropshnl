<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToVehicleServiceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_service_log', function (Blueprint $table) {
            //
            $table->string('fault_desc')->nullable();
            $table->date('diagnosis_date')->nullable();
            $table->date('estimated_complete_date')->nullable();
            $table->date('actual_complete_date')->nullable();
            $table->integer('actual_complete_time')->nullable();
            $table->text('spares_required')->nullable();
            $table->text('service_parts')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('next_action')->nullable();
            $table->integer('active_status')->nullable();

            $table->text('approval_json')->nullable();
            $table->text('approval_level')->nullable();
            $table->text('approval_user')->nullable();
            $table->text('approved_users')->nullable();
            $table->text('edit_request')->nullable();
            $table->integer('approval_id')->nullable();
            $table->integer('complete_status')->nullable();
            $table->integer('deny_user')->nullable();
            $table->text('deny_reason')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('approval_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_service_log', function (Blueprint $table) {
            //
        });
    }
}
