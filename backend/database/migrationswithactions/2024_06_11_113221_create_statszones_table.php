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
        Schema::create('createstatszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('statszone_id');

        });
        Schema::create('updatestatszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('statszone_id');

        });
        Schema::create('deletestatszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('statszone_id');

        });
        Schema::create('readstatszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('statszone_id');

        });
        Schema::create('statszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom1')->nullable();
            $table->unsignedBigInteger('modelslistingnuit1_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour1_id')->nullable();
            $table->string('nom2')->nullable();
            $table->unsignedBigInteger('modelslistingnuit2_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour2_id')->nullable();
            $table->string('nom3')->nullable();
            $table->unsignedBigInteger('modelslistingnuit3_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour3_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('modelslistingnuit1')->nullable();
            $table->string('modelslistingnuit2')->nullable();
            $table->string('modelslistingnuit3')->nullable();
            $table->string('modelslistingjour1')->nullable();
            $table->string('modelslistingjour2')->nullable();
            $table->string('modelslistingjour3')->nullable();
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
        Schema::dropIfExists('statszones');
    }
};
