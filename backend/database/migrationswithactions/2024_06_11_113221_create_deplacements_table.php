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
        Schema::create('createdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deplacement_id');

        });
        Schema::create('updatedeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deplacement_id');

        });
        Schema::create('deletedeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deplacement_id');

        });
        Schema::create('readdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deplacement_id');

        });
        Schema::create('deplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->string('debut_prevu')->nullable();
            $table->string('fin_prevu')->nullable();
            $table->unsignedBigInteger('lignesmoyenstransport_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('moyenstransport_id')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
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
        Schema::dropIfExists('deplacements');
    }
};
