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
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn('site')->nullable();
        });
        Schema::table('interventions', function (Blueprint $table) {
            $table->string('site_id')->nullable();
            $table->string('site_libelle')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_libelle')->nullable();
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
        Schema::table('interventions', function (Blueprint $table) {
            $table->string('site')->nullable();
        });
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn('site_id');
            $table->dropColumn('site_libelle');
            $table->dropColumn('client_id');
            $table->dropColumn('client_libelle');
        });
    }
};
