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
        try {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('matricule');
            $table->dropColumn('actif_id');
            $table->dropColumn('nationalite_id');
            $table->dropColumn('contrat_id');
            $table->dropColumn('direction_id');
            $table->dropColumn('categorie_id');
            $table->dropColumn('echelon_id');
            $table->dropColumn('sexe_id');
            $table->dropColumn('matrimoniale_id');
            $table->dropColumn('poste_id');
            $table->dropColumn('ville_id');
            $table->dropColumn('zone_id');
            $table->dropColumn('situation_id');
            $table->dropColumn('balise_id');
            $table->dropColumn('fonction_id');
            $table->dropColumn('online_id');
            $table->dropColumn('faction_id');
            $table->dropColumn('site_id');
            $table->dropColumn('client_id');
            $table->dropColumn('pointeusepostes');
            $table->dropColumn('verification');
            $table->dropColumn('rechercheetape');
            $table->dropColumn('tache');
            $table->dropColumn('poste');
            $table->dropColumn('TachesPotentiels');
            $table->dropColumn('PostesPotentiels');
            $table->dropColumn('TotalPostes');
            $table->dropColumn('TotalPostescouvert');
            $table->dropColumn('TotalPostesnoncouvert');
            $table->dropColumn('TotalPostessouscouvert');
            $table->dropColumn('heure');
            $table->dropColumn('identification_id');
            $table->dropColumn('controlleursacce_id');
            $table->dropColumn('client_id');
            $table->dropColumn('actif_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('montant')->nullable();
        });
    } catch (\Throwable $e) {

    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('nom');
            $table->string('prenom');
            $table->string('matricule');
            $table->unsignedBigInteger('actif_id');
            $table->unsignedBigInteger('nationalite_id');
            $table->unsignedBigInteger('contrat_id');
            $table->unsignedBigInteger('direction_id');
            $table->unsignedBigInteger('categorie_id');
            $table->unsignedBigInteger('echelon_id');
            $table->unsignedBigInteger('sexe_id');
            $table->unsignedBigInteger('matrimoniale_id');
            $table->unsignedBigInteger('poste_id');
            $table->unsignedBigInteger('ville_id');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('situation_id');
            $table->unsignedBigInteger('balise_id');
            $table->unsignedBigInteger('fonction_id');
            $table->unsignedBigInteger('online_id');
            $table->unsignedBigInteger('faction_id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('client_id');
            $table->string('pointeusepostes');
            $table->string('verification');
            $table->string('rechercheetape');
            $table->string('tache');
            $table->string('poste');
            $table->string('TachesPotentiels');
            $table->string('PostesPotentiels');
            $table->string('TotalPostes');
            $table->string('TotalPostescouvert');
            $table->string('TotalPostesnoncouvert');
            $table->string('TotalPostessouscouvert');
            $table->string('heure');
            $table->unsignedBigInteger('identification_id');
            $table->unsignedBigInteger('controlleursacce_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('actif_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('montant')->nullable();
        });
    }
};
