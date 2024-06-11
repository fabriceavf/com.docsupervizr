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
        Schema::create('createtraitements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traitement_id');

        });
        Schema::create('updatetraitements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traitement_id');

        });
        Schema::create('deletetraitements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traitement_id');

        });
        Schema::create('readtraitements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traitement_id');

        });
        Schema::create('traitements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->date('date')->nullable();
            $table->string('etat_depart')->nullable();
            $table->string('etat_arrive')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('traitements');
    }
};
