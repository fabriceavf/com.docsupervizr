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
        Schema::create('createlignesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lignesmoyenstransport_id');

        });
        Schema::create('updatelignesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lignesmoyenstransport_id');

        });
        Schema::create('deletelignesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lignesmoyenstransport_id');

        });
        Schema::create('readlignesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lignesmoyenstransport_id');

        });
        Schema::create('lignesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('moyenstransport_id')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->string('heure_debut')->nullable();
            $table->string('heure_fin')->nullable();
            $table->integer('lun')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('mer')->default(0);
            $table->integer('jeu')->default(0);
            $table->integer('ven')->default(0);
            $table->integer('sam')->default(0);
            $table->integer('dim')->default(0);
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
        Schema::dropIfExists('lignesmoyenstransports');
    }
};
