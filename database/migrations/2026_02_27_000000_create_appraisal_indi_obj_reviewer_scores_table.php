<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalIndiObjReviewerScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_indi_obj_reviewer_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('goal_set_id')->nullable();
            $table->integer('obj_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('reviewer_user_id')->nullable();
            $table->string('score')->nullable();
            $table->string('total_score')->nullable();
            $table->string('final_score')->nullable();
            $table->string('perct_score')->nullable();
            $table->text('comment')->nullable();
            $table->integer('arc_status')->nullable();
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
        Schema::dropIfExists('appraisal_indi_obj_reviewer_scores');
    }
}
