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
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->dropColumn('query');
            $table->dropColumn('params');
            $table->dropColumn('date');
            $table->dropColumn('lun');
            $table->dropColumn('mar');
            $table->dropColumn('mer');
            $table->dropColumn('jeu');
            $table->dropColumn('ven');
            $table->dropColumn('sam');
            $table->dropColumn('dim');
        });
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->string('etats')->nullable();
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
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->string('query')->nullable();
            $table->string('params')->nullable();
            $table->string('date')->nullable();
            $table->string('lun')->nullable();
            $table->string('mar')->nullable();
            $table->string('mer')->nullable();
            $table->string('jeu')->nullable();
            $table->string('ven')->nullable();
            $table->string('sam')->nullable();
            $table->string('dim')->nullable();
        });
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->dropColumn('etats');
        });
    }
};
