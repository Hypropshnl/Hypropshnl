<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsPoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_pool', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_designation')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('company_no')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('vat_no')->nullable();
            $table->text('job_category')->nullable();
            $table->text('memo')->nullable();
            $table->integer('currency')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_sort_code')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('hse_policy')->nullable();
            $table->string('qa_cert')->nullable();
            $table->string('qhse_contact')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('vendors_pool');
    }
}
