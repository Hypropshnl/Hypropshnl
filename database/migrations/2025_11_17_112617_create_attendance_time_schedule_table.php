<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTimeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_time_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('desc')->nullable();
            $table->integer('geo_tag_id')->nullable();
            $table->integer('time_zone_id')->nullable();
            $table->string('work_days')->nullable();
            $table->string('late_start_time')->nullable();
            $table->string('late_count_notify')->nullable();
            $table->string('late_request_start_time')->nullable();
            $table->string('late_request_end_time')->nullable();
            $table->string('absence_start_time')->nullable();
            $table->string('absence_count_notify')->nullable();
            $table->string('absence_request_start_time')->nullable();
            $table->string('absence_request_end_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('break_time_start')->nullable();
            $table->string('break_time_end')->nullable();
            $table->string('break_period')->nullable();
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
        Schema::dropIfExists('attendance_time_schedule');
    }
}
