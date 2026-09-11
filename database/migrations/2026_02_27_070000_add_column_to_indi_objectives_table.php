<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToIndiObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indi_objectives', function (Blueprint $table) {
            $table->string('attachment')->nullable();
            $table->string('start_value')->nullable();
            $table->string('target_value')->nullable();
            $table->string('score')->nullable();
            $table->string('total_score')->nullable();
            $table->text('comment')->nullable();
            $table->string('employee_perct_score')->nullable();
            $table->string('reviewer_score')->nullable();
            $table->string('reviewer_perct_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indi_objectives', function (Blueprint $table) {
            
        });
    }
}
