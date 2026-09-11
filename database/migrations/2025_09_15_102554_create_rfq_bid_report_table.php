<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqBidReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_bid_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rfq_id');
            $table->integer('dept_id')->nullable();
            $table->text('total_amount')->nullable();
            $table->text('response_message')->nullable();
            $table->text('approval_json')->nullable();
            $table->text('approval_level')->nullable();
            $table->text('approval_user')->nullable();
            $table->text('approved_users')->nullable();
            $table->integer('approval_id')->nullable();
            $table->integer('complete_status')->nullable();
            $table->integer('deny_user')->nullable();
            $table->text('deny_reason')->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('status');
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
        Schema::dropIfExists('rfq_bid_report');
    }
}
