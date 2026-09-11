<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalReviewerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_reviewer_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('obj_comments')->nullable();
            $table->text('tech_comments')->nullable();
            $table->text('behav_comments')->nullable();
            $table->text('overview_strength')->nullable();
            $table->text('area_improv')->nullable();
            $table->text('suggest_pp_dev')->nullable();
            $table->integer('indi_goal')->nullable();
            $table->integer('reviewer_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('goal_set_id')->nullable();
            $table->integer('recommendation_id')->nullable();
            $table->integer('rating_id')->nullable();
            $table->integer('arc_status')->nullable();
            $table->text('rev_sign')->nullable();
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
        Schema::dropIfExists('appraisal_reviewer_comments');
    }
}
