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
        Schema::table('pointeuses', function (Blueprint $table) {
            $table->renameColumn('findId', 'nom_local');
            $table->unsignedBigInteger('supervirzclient_id')->nullable();
            $table->dropColumn('recupere_id');
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
        Schema::table('pointeuses', function (Blueprint $table) {
            //
        });
    }
};
