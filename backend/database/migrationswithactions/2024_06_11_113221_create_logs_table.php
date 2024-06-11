<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('createlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_id');

        });
        Schema::create('updatelogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_id');

        });
        Schema::create('deletelogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_id');

        });
        Schema::create('readlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_id');

        });
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('action')->nullable()->comment('is_select_label');
            $table->string('ip')->nullable()->comment('is_select_label');
            $table->text('details')->nullable();
            $table->string('navigateur')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->json('extra_attributes')->nullable();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
