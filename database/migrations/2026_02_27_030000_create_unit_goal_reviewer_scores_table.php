<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitGoalReviewerScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_goal_reviewer_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('goal_set_id')->nullable();
            $table->integer('unit_goal_ext_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('reviewer_user_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('score')->nullable();
            $table->string('total_score')->nullable();
            $table->string('final_score')->nullable();
            $table->string('perct_score')->nullable();
            $table->integer('arc_status')->nullable();
            $table->text('comment')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('unit_goal_reviewer_scores');
    }
}
