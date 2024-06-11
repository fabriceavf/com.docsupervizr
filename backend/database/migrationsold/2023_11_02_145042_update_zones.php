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

        Schema::table('zones', function (Blueprint $table) {
            $table->integer('total_titulaires_therorique')->default(0);
            $table->integer('total_titulaires_reel_jour')->default(0);
            $table->integer('total_titulaires_reel_nuit')->default(0);
            $table->integer('total_present_jour')->default(0);
            $table->integer('total_present_nuit')->default(0);
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
        Schema::table('zones', function (Blueprint $table) {
            $table->dropColumn('total_titulaires_therorique');
            $table->dropColumn('total_titulaires_reel_jour');
            $table->dropColumn('total_titulaires_reel_nuit');
            $table->dropColumn('total_present_jour');
            $table->dropColumn('total_present_nuit');
        });
    }
};
