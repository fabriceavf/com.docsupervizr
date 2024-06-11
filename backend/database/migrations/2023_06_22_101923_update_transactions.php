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
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('annuler')->default(0);
            $table->string('type')->default('auto');
            $table->boolean('traiter')->default(0);
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('annuler');
            $table->dropColumn('type');
            $table->dropColumn('traiter');
        });
    }
};
