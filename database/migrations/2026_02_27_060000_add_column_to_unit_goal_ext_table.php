<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUnitGoalExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_goal_ext', function (Blueprint $table) {
            $table->integer('type')->nullable();
            $table->string('attachment')->nullable();
            $table->text('desired_result')->nullable();
            $table->text('comment')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('frequency')->nullable();
            $table->string('weight')->nullable();
            $table->string('start_value')->nullable();
            $table->string('target_value')->nullable();
            $table->string('score')->nullable();
            $table->string('total_score')->nullable();
            $table->string('employee_perct_score')->nullable();
            $table->string('reviewer_score')->nullable();
            $table->string('reviewer_perct_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_goal_ext', function (Blueprint $table) {
            
        });
    }
}
