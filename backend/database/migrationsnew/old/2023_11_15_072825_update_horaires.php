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
            $table->string('vol_horaire_min')->nullable();
            $table->string('nmb_pointage_min')->nullable();
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
            $table->dropColumn('vol_horaire_min');
            $table->dropColumn('nmb_pointage_min');
        });
    }
};
