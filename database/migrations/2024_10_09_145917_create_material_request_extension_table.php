<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialRequestExtensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_request_extension', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid');
            $table->bigInteger('assigned_user')->nullable();
            $table->string('mr_number')->nullable();
            $table->date('due_date')->nullable();
            $table->text('message')->nullable();
            $table->text('attachment')->nullable();
            $table->text('vendor_message')->nullable();
            $table->text('mails')->nullable();
            $table->text('mail_copy')->nullable();
            $table->text('approval_json')->nullable();
            $table->text('approval_level')->nullable();
            $table->text('approval_user')->nullable();
            $table->text('approved_users')->nullable();
            $table->integer('approval_id')->nullable();
            $table->integer('complete_status')->nullable();
            $table->integer('deny_user')->nullable();
            $table->text('deny_reason')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('mail_status')->nullable();
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
        Schema::dropIfExists('material_request_extension');
    }
}
