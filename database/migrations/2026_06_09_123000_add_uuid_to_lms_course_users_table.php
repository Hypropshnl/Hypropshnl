<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddUuidToLmsCourseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lms_course_users', function (Blueprint $table) {
            $table->string('uuid', 100)->nullable()->unique()->after('id');
            $table->string('uid', 100)->nullable()->unique()->before('course_id');
            $table->string('certificate_doc', 100)->nullable()->after('visited_topics');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lms_course_users', function (Blueprint $table) {
            //$table->dropColumn('uuid');
        });
    }
}
