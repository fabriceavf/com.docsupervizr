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
        Schema::dropIfExists('materielinterventiondetails');
        Schema::create('materielinterventiondetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->unsignedBigInteger('materielintervention_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->timestamps();
        });

        Schema::table('materielinterventions', function (Blueprint $table) {
            $table->dropColumn('materiel_id');
            $table->dropColumn('quantite');
            $table->boolean('valider');
        });
        Schema::table('approvisionements', function (Blueprint $table) {
            $table->boolean('valider');
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
        Schema::dropIfExists('materielinterventiondetails');
        Schema::table('materielinterventions', function (Blueprint $table) {
            $table->dropColumn('valider');
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->integer('quantite')->nullable();
        });
        Schema::table('approvisionements', function (Blueprint $table) {
            $table->dropColumn('valider');
        });
    }
};
