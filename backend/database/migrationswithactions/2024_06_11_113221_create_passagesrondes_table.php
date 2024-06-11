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
        Schema::create('createpassagesrondes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passagesronde_id');

        });
        Schema::create('updatepassagesrondes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passagesronde_id');

        });
        Schema::create('deletepassagesrondes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passagesronde_id');

        });
        Schema::create('readpassagesrondes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passagesronde_id');

        });
        Schema::create('passagesrondes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->integer('lun')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('mer')->default(0);
            $table->integer('jeu')->default(0);
            $table->integer('ven')->default(0);
            $table->integer('sam')->default(0);
            $table->integer('dim')->default(0);
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('libelle')->nullable();
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
        Schema::dropIfExists('passagesrondes');
    }
};
