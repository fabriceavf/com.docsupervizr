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
        Schema::table('postes', function (Blueprint $table) {
            $table->dropColumn('contrat');
            $table->string('jours');
            $table->unsignedBigInteger('contratsclient_id')->nullable()->index('postes_contratsclient_id_foreign');
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
        Schema::table('postes', function (Blueprint $table) {
            $table->string('contrat');
            $table->dropColumn('jours');
            $table->dropColumn('contratsclient_id');
        });
    }
};
