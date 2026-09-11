<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('cert_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('company_name')->nullable();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('sub_heading_two')->nullable();
            $table->string('cert_num_format')->nullable();
            $table->string('template_doc')->nullable();
            $table->string('cert_id_display')->nullable();
            $table->string('stamp')->nullable();
            $table->string('cert_name_pos')->nullable();
            $table->string('logo_pos')->nullable();
            $table->string('company_name_pos')->nullable();
            $table->string('heading_pos')->nullable();
            $table->string('sub_heading_pos')->nullable();
            $table->string('sub_heading_two_pos')->nullable();
            $table->string('cert_num_format_pos')->nullable();
            $table->string('cert_id_display_pos')->nullable();
            $table->string('stamp_pos')->nullable();
            $table->string('qr_code_pos')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('certificate_template');
    }
}
