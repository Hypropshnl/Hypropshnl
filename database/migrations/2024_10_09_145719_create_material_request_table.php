<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid');
            $table->integer('item_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->string('unit_measurement')->nullable();
            $table->text('mr_desc')->nullable();
            $table->integer('mr_id')->nullable();
            $table->bigInteger('assigned_user')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_request');
    }
}
