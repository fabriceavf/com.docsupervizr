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
        Schema::create('createuserszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userszone_id');

        });
        Schema::create('updateuserszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userszone_id');

        });
        Schema::create('deleteuserszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userszone_id');

        });
        Schema::create('readuserszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userszone_id');

        });
        Schema::create('userszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
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
        Schema::dropIfExists('userszones');
    }
};
