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

//        Schema::table('users', function (Blueprint $table) {
//
//            $table->string('#rajouterUser')->nullable();
//            $table->string('#modifierUser')->nullable();
//            $table->string('#VoirUser')->nullable();
//            $table->string('#deleteUser')->nullable();
//
//            $table->string('#rajouterUtilisateur')->nullable();
//            $table->string('#modifierUtilisateur')->nullable();
//            $table->string('#VoirUtilisateur')->nullable();
//            $table->string('#deleteUtilisateur')->nullable();
//
//            $table->string('#rajouterSuperAdmin')->nullable();
//            $table->string('#modifierSuperAdmin')->nullable();
//            $table->string('#VoirSuperAdmin')->nullable();
//            $table->string('#deleteSuperAdmin')->nullable();
//
//            $table->string('#rajouterAgent')->nullable();
//            $table->string('#modifierAgent')->nullable();
//            $table->string('#VoirAgent')->nullable();
//            $table->string('#deleteAgent')->nullable();
//
//            $table->string('#changeUserPassword')->nullable();
//            $table->string('#changeAgentSituations')->nullable();
//
//
//        });
//
//        Schema::table('postes', function (Blueprint $table) {
//            $table->string('#rajouterPoste')->nullable();
//            $table->string('#modifierPoste')->nullable();
//            $table->string('#VoirPoste')->nullable();
//            $table->string('#deletePoste')->nullable();
//            $table->string('#recupererNombreAgentsTitulaireParFaction')->nullable();
//            $table->string('#AffecterAgentPoste')->nullable();
//            $table->string('#retirerAgentAffecterPoste')->nullable();
//            $table->string('#modifierJourAffectionAgentPoste')->nullable();
//            $table->string('#modifierStatusAgentAffecterPoste')->nullable();
//        });
//
//        Schema::table('programmations', function (Blueprint $table) {
//            $table->string('#rajouterPlanification')->nullable();
//            $table->string('#modifierPlanification')->nullable();
//            $table->string('#VoirPlanification')->nullable();
//            $table->string('#deletePlanification')->nullable();
//            $table->string('#genererListings')->nullable();
//            $table->string('#rattacherPosteFaction')->nullable();
//            $table->string('#retirerPosteFaction')->nullable();
//            $table->string('#rattacherDirection')->nullable();
//            $table->string('#retirerDirection')->nullable();
//            $table->string('#rattacherValideur')->nullable();
//            $table->string('#retirerValideur')->nullable();
//            $table->string('#calculerNombresListingsComplet')->nullable();
//            $table->string('#calculerNombresListingsInComplet')->nullable();
//            $table->string('#calculerNombresListingsNonDemarrer')->nullable();
//        });
//
//        Schema::table('modelslistings', function (Blueprint $table) {
//            $table->string('#calculerNombresAgentsPresent')->nullable();
//            $table->string('#calculerNombresAgentsAbscent')->nullable();
//            $table->string('#valider')->nullable();
//            $table->string('#declarerPresent')->nullable();
//            $table->string('#declarerAbscent')->nullable();
//            $table->string('#retirerAgentDuListing')->nullable();
//            $table->string('#ajouterRemplacant')->nullable();
//            $table->string('#ajouterPointageDebutAgent')->nullable();
//            $table->string('#ajouterPointageFinAgent')->nullable();
//            $table->string('#qualifierHeureTravaillerParAgent')->nullable();
//            $table->string('#calculerNombrePointagesCollecterParAgent')->nullable();
//        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
