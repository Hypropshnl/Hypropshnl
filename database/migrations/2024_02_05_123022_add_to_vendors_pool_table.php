<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToVendorsPoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors_pool', function (Blueprint $table) {
            //
            $table->string('refrence')->nullable();
            $table->string('refrence_docs')->nullable();
            $table->string('hse_policy_docs')->nullable();
            $table->string('qa_docs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors_pool', function (Blueprint $table) {
            //
        });
    }
}
