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
                $table->dropColumn('echelon_id')->nullable();
                $table->dropColumn('sexe_id')->nullable();
                $table->dropColumn('matrimoniale_id')->nullable();
                $table->dropColumn('zone_id')->nullable();
                $table->dropColumn('balise_id')->nullable();
                $table->dropColumn('fonction_id')->nullable();
                $table->dropColumn('online_id')->nullable();
                $table->dropColumn('faction_id')->nullable();
                $table->dropColumn('site_id')->nullable();
                $table->dropColumn('client_id')->nullable();
                $table->dropColumn('tache')->nullable();
                $table->dropColumn('poste')->nullable();
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
        try {
            Schema::table('transactions', function (Blueprint $table) {

                $table->string('echelon_id')->nullable();
                $table->string('sexe_id')->nullable();
                $table->string('matrimoniale_id')->nullable();
                $table->string('zone_id')->nullable();
                $table->string('balise_id')->nullable();
                $table->string('fonction_id')->nullable();
                $table->string('online_id')->nullable();
                $table->string('faction_id')->nullable();
                $table->string('site_id')->nullable();
                $table->string('client_id')->nullable();
                $table->string('tache')->nullable();
                $table->string('poste')->nullable();
            });
        } catch (\Throwable $e) {

        }
    }
};
