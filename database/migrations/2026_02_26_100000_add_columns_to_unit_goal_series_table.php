<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUnitGoalSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_goal_series', function (Blueprint $table) {
            $table->text('desc')->nullable();
            $table->integer('appraisal_type')->nullable();
            $table->integer('survey_id')->nullable();
            $table->boolean('auto_recommend')->nullable();
            $table->dateTime('employee_deadline')->nullable();
            $table->dateTime('reviewer_deadline')->nullable();
            $table->string('obj_weight')->nullable();
            $table->string('tech_weight')->nullable();
            $table->string('behav_weight')->nullable();
            $table->string('total_weight')->nullable();
            $table->text('recommend_data')->nullable();
            $table->integer('notify_num')->nullable();
            $table->integer('frequency')->nullable();
            $table->string('time')->nullable();
            $table->integer('bsc_okr_obj_merge_status')->nullable();
            $table->date('date_tracker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_goal_series', function (Blueprint $table) {
           
        });
    }
}
