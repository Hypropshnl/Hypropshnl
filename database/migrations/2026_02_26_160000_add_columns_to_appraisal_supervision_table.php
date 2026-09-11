<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAppraisalSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisal_supervision', function (Blueprint $table) {
            $table->text('arc_data')->nullable();
            $table->text('arc_reviews')->nullable();
            $table->text('arc_users')->nullable();
            $table->integer('arc_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appraisal_supervision', function (Blueprint $table) {
            
        });
    }
}
