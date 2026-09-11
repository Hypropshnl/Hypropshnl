<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToVendorCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_customer', function (Blueprint $table) {
            //
            $table->string('vat_no')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('memo')->nullable();
            $table->string('bank_sort_code')->nullable();
            $table->text('job_category')->nullable();
            $table->string('hse_policy')->nullable();
            $table->string('qa_cert')->nullable();
            $table->string('qhse_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_customer', function (Blueprint $table) {
            //
            $table->dropColumn('vat_no');
            $table->dropColumn('annual_turnover');
            $table->dropColumn('bank_branch');
            $table->dropColumn('memo');
            $table->dropColumn('bank_sort_code');
            $table->dropColumn('job_category');
            $table->dropColumn('hse_policy');
            $table->dropColumn('qa_cert');
            $table->dropColumn('qhse_contact');
        });
    }
}
