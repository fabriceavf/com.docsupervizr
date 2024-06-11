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
                $table->string('cout')->nullable();
                $table->dropColumn('actif_id')->nullable();
                $table->dropColumn('nationalite_id')->nullable();
                $table->dropColumn('contrat_id')->nullable();
                $table->dropColumn('direction_id')->nullable();
                $table->dropColumn('categorie_id')->nullable();
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
                $table->dropColumn('cout')->nullable();
                $table->string('actif_id')->nullable();
                $table->string('nationalite_id')->nullable();
                $table->string('contrat_id')->nullable();
                $table->string('direction_id')->nullable();
                $table->string('categorie_id')->nullable();
            });
        } catch (\Throwable $e) {

        }
    }
};
