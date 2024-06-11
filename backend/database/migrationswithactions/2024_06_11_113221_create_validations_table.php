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
        Schema::create('createvalidations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('validation_id');

        });
        Schema::create('updatevalidations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('validation_id');

        });
        Schema::create('deletevalidations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('validation_id');

        });
        Schema::create('readvalidations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('validation_id');

        });
        Schema::create('validations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->string('users')->nullable();
            $table->unsignedBigInteger('modelslisting_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('nmbvalideurs')->nullable();
            $table->string('identifiants_sadge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validations');
    }
};
