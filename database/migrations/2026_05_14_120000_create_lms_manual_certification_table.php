<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLMSManualCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_manual_certification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 255)->nullable();
            $table->string('uid', 255)->nullable();
            $table->integer('course_id')->nullable();
            $table->string('certificate_doc', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('temp_user')->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('status')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('LMS_manual_certification');
    }
}
