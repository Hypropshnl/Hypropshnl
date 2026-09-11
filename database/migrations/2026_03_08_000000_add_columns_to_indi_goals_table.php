<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToIndiGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
Schema::table('indi_goals', function (Blueprint $table) {
            $table->string('weighted_score')->nullable();
            $table->string('perct_score')->nullable();
            $table->string('weighted_overall_score')->nullable();
            $table->string('weighted_overall_score_perct')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indi_goals', function (Blueprint $table) {
           
        });
    }
}
