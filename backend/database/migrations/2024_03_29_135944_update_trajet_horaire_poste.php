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
        Schema::table('trajets', function (Blueprint $table) {
            $table->string('ordre')->nullable();
        });
        Schema::table('horairestypespostes', function (Blueprint $table) {
            $table->string('ordre')->nullable();
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
        Schema::table('trajets', function (Blueprint $table) {
            $table->dropColumn('ordre');
        });
        Schema::table('horairestypespostes', function (Blueprint $table) {
            $table->dropColumn('ordre');
        });
    }
};
