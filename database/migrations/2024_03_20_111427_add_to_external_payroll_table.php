<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToExternalPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_payroll', function (Blueprint $table) {
            //
            $table->string('rate')->nullable();
            $table->string('days_hours')->nullable();
            $table->string('days_hours_engage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_payroll', function (Blueprint $table) {
            //
        });
    }
}
