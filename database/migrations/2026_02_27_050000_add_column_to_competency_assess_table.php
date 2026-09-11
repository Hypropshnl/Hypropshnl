<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCompetencyAssessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competency_assess', function (Blueprint $table) {
            $table->string('attachment')->nullable();
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
        Schema::table('competency_assess', function (Blueprint $table) {
            
        });
    }
}
