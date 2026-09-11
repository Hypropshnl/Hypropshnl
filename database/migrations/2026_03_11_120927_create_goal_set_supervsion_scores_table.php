<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalSetSupervsionScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_set_supervision_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('goal_set_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('supervisor_id')->nullable();
            $table->string('arc_data')->nullable();
            $table->string('arc_users')->nullable();
            $table->string('arc_reviews')->nullable();
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
        Schema::dropIfExists('goal_set_supervision_scores');
    }
}
