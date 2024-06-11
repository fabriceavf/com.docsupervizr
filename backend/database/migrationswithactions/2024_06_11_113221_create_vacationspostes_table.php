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
        Schema::create('createvacationspostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vacationsposte_id');

        });
        Schema::create('updatevacationspostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vacationsposte_id');

        });
        Schema::create('deletevacationspostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vacationsposte_id');

        });
        Schema::create('readvacationspostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vacationsposte_id');

        });
        Schema::create('vacationspostes', function (Blueprint $table) {
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
        Schema::dropIfExists('vacationspostes');
    }
};
