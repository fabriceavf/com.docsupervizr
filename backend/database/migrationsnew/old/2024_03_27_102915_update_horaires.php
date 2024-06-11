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
        Schema::table('horaires', function (Blueprint $table) {
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->dropColumn('tache_id');
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
        Schema::table('horaires', function (Blueprint $table) {
            $table->dropColumn('poste_id');
            $table->unsignedBigInteger('tache_id')->nullable();

        });
    }
};
