<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToJobListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_list', function (Blueprint $table) {
            //
            $table->text('keywords')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('weighted_score')->nullable();
            $table->integer('action_taken')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_list', function (Blueprint $table) {
            //
        });
    }
}
