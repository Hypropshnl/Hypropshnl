<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToLmsCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lms_course', function (Blueprint $table) {
            $table->integer('certificate_template_id')->nullable();
            $table->string('duration')->nullable();
            $table->string('name_one')->nullable();
            $table->string('name_two')->nullable();
            $table->string('name_one_role')->nullable();
            $table->string('name_two_role')->nullable();
            $table->string('name_one_sign')->nullable();
            $table->string('name_two_sign')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lms_course', function (Blueprint $table) {
            
        });
    }
}
