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
        Schema::create('createrapportpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rapportposte_id');

        });
        Schema::create('updaterapportpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rapportposte_id');

        });
        Schema::create('deleterapportpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rapportposte_id');

        });
        Schema::create('readrapportpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rapportposte_id');

        });
        Schema::create('rapportpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('total')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
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
        Schema::dropIfExists('rapportpostes');
    }
};
