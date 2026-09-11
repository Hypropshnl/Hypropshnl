<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingFeedbackComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_feedback_comment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('training_id');
            $table->integer('user_id');
            $table->text('most_useful')->nullable();
            $table->text('least_useful')->nullable();
            $table->text('summary')->nullable();
            $table->text('implementation')->nullable();
            $table->text('suggestion')->nullable();
            $table->string('user_sign')->nullable();
            $table->string('hr_sign')->nullable();
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
        Schema::dropIfExists('training_feedback_comment');
    }
}
