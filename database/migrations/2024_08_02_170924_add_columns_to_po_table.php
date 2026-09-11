<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_extention', function (Blueprint $table) {
            //
            $table->longText('approval_json')->nullable();
            $table->longText('approval_level')->nullable();
            $table->longText('approval_user')->nullable();
            $table->longText('approved_users')->nullable();
            $table->integer('approval_id')->nullable();
            $table->integer('complete_status')->nullable();
            $table->integer('deny_user')->nullable();
            $table->string('deny_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_extention', function (Blueprint $table) {
            //
        });
    }
}
