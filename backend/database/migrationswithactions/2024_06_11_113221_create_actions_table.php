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
        Schema::create('createactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_id');

        });
        Schema::create('updateactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_id');

        });
        Schema::create('deleteactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_id');

        });
        Schema::create('readactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_id');

        });
        Schema::create('actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('work_id')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('actions');
    }
};
