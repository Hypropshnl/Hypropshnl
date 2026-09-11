<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameRolesToOfflineCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->string('name_one_role')->nullable()->after('name_one');
            $table->string('name_two_role')->nullable()->after('name_two');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            if (Schema::hasColumn('offline_courses', 'name_one_role')) {
                $table->dropColumn('name_one_role');
            }
            if (Schema::hasColumn('offline_courses', 'name_two_role')) {
                $table->dropColumn('name_two_role');
            }
        });
    }
}
