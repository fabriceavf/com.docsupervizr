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
        Schema::create('createalarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alarm_id');

        });
        Schema::create('updatealarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alarm_id');

        });
        Schema::create('deletealarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alarm_id');

        });
        Schema::create('readalarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alarm_id');

        });
        Schema::create('alarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('alarms');
    }
};
