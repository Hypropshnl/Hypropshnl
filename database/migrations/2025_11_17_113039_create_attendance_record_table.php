<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->integer('time_request_id')->nullable();
            $table->text('location')->nullable();
            $table->string('lat_long')->nullable();
            $table->text('comment')->nullable();
            $table->text('comment_out')->nullable();
            $table->date('date')->nullable();
            $table->string('clock_in')->nullable();
            $table->string('clock_out')->nullable();
            $table->string('clock_in_photo')->nullable();
            $table->string('clock_out_photo')->nullable();
            $table->integer('attendance_status')->nullable();
            $table->integer('total_hours')->nullable();
            $table->integer('regular_hours')->nullable();
            $table->integer('overtime')->nullable();
            $table->integer('day')->nullable();
            $table->integer('status')->nullable();
            $table->integer('cron_status')->nullable();
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
        Schema::dropIfExists('attendance_record');
    }
}
