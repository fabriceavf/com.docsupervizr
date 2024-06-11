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
        Schema::create('programmations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->comment('is_select_label');
            $table->text('description')->nullable()->comment('types_textarea');
            $table->timestamp('date_debut')->nullable()->comment('types_datetime');
            $table->timestamp('date_fin')->nullable()->comment('types_datetime');
            $table->string('default_heure_debut')->nullable();
            $table->string('default_heure_fin')->nullable();
            $table->unsignedBigInteger('tache_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('statut')->default('En cours...');
            $table->string('type')->default('programmations');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('poste_id')->nullable()->default(0);
            $table->string('faction')->nullable();
            $table->string('etats')->nullable();
            $table->timestamp('valider1')->nullable();
            $table->timestamp('valider2')->nullable();
            $table->text('postes')->nullable();
            $table->longText('Allclients')->nullable();
            $table->longText('AllDatesInRange')->nullable();
            $table->longText('Presents')->nullable();
            $table->longText('Abscents')->nullable();
            $table->longText('Presentsid')->nullable();
            $table->longText('Abscentsid')->nullable();
            $table->unsignedInteger('zone_id')->nullable();
            $table->unsignedBigInteger('user_id_2');
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('user_id_4')->nullable();
            $table->string('min_pointage')->nullable();
            $table->string('valideur_1')->nullable();
            $table->string('valideur_2')->nullable();
            $table->string('typelistings')->nullable();
            $table->string('postesbaladeur')->nullable();
            $table->string('directions')->nullable();
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
        Schema::dropIfExists('programmations');
    }
};
