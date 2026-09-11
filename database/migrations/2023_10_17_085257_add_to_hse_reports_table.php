<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToHseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_reports', function (Blueprint $table) {
            //
            $table->string('time')->nullable();
            $table->text('action_taken')->nullable();
            $table->string('reported_by')->nullable();
            $table->text('causes')->nullable();
            $table->text('remedial_actions')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->string('reviewed_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_reports', function (Blueprint $table) {
            //
        });
    }
}
