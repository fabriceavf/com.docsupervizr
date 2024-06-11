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
        try{
        Schema::dropIfExists('mesurespreventives');
        Schema::create('mesurespreventives', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('causeracines');
        Schema::create('causeracines', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('chantiers');
        Schema::create('chantiers', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('couleur')->nullable();
            $table->date('debut_prevus')->nullable();
            $table->date('fin_prevus')->nullable();
            $table->date('debut_effectif')->nullable();
            $table->date('fin_effectif')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('chantierlocalisations');
        Schema::create('chantierlocalisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chantier_id')->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('typeinterventions');
        Schema::create('typeinterventions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('interventions');
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('detail')->nullable();
            $table->unsignedBigInteger('typeintervention_id')->nullable();
            $table->unsignedBigInteger('mesurespreventive_id')->nullable();
            $table->unsignedBigInteger('causeracine_id')->nullable();
            $table->unsignedBigInteger('chantier_id')->nullable();
            $table->date('debut_prevus')->nullable();
            $table->date('fin_prevus')->nullable();
            $table->date('debut_effectif')->nullable();
            $table->date('fin_effectif')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('interventionimages');
        Schema::create('interventionimages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intervention_id')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('interventionusers');
        Schema::create('interventionusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intervention_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('interventiondetails');
        Schema::create('interventiondetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interventionuser_id')->nullable();
            $table->string('jour')->nullable();
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('materiels');
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantite')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('materielinterventions');
        Schema::create('materielinterventions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->unsignedBigInteger('intervention_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->string('type')->nullable();
            $table->string('libelle')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('materielprevisionnels');
        Schema::create('materielprevisionnels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->unsignedBigInteger('chantier_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('approvisionements');
        Schema::create('approvisionements', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('approvisionementdetails');
        Schema::create('approvisionementdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approvisionement_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->timestamps();
        });
     }catch (\Throwable $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mesurespreventives');
        Schema::dropIfExists('causeracines');
        Schema::dropIfExists('chantiers');
        Schema::dropIfExists('chantierlocalisations');
        Schema::dropIfExists('typeinterventions');
        Schema::dropIfExists('interventions');
        Schema::dropIfExists('interventionimages');
        Schema::dropIfExists('interventionusers');
        Schema::dropIfExists('interventiondetails');
        Schema::dropIfExists('materiels');
        Schema::dropIfExists('materielinterventions');
        Schema::dropIfExists('materielprevisionnels');
        Schema::dropIfExists('approvisionements');
        Schema::dropIfExists('approvisionementdetails');
    }
};
