<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfflineCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->integer('cert_template_id')->nullable();
            $table->string('location')->nullable();
            $table->string('actual_name_one')->nullable();
            $table->string('actual_name_two')->nullable();
            $table->string('name_one')->nullable();
            $table->string('name_two')->nullable();
            $table->string('name_one_sign')->nullable();
            $table->string('name_two_sign')->nullable();
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
        Schema::dropIfExists('offline_courses');
    }
}
