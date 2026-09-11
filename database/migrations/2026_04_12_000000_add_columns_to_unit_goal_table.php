<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUnitGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_goals', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('total_obj_weight')->nullable();
            $table->string('weighted_score')->nullable();
            $table->string('perct_score')->nullable();
            $table->string('overall_weighted_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_goal', function (Blueprint $table) {
           
        });
    }
}
