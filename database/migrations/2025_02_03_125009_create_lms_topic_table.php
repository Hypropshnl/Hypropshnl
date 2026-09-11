<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_topic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('lesson_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->string('photo')->nullable();
            $table->text('content')->nullable();
            $table->string('documents')->nullable();
            $table->integer('youtube')->nullable();
            $table->integer('score_mark')->nullable();
            $table->string('deadline')->nullable();
            $table->string('words_limit')->nullable();
            $table->string('organizer')->nullable();
            $table->date('event_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->integer('active_status')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('lms_topic');
    }
}
