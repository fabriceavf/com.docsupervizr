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
            $table->integer('lun')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('mer')->default(0);
            $table->integer('jeu')->default(0);
            $table->integer('ven')->default(0);
            $table->integer('sam')->default(0);
            $table->integer('dim')->default(0);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

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
            $table->dropColumn('lun');
            $table->dropColumn('mar');
            $table->dropColumn('mer');
            $table->dropColumn('jeu');
            $table->dropColumn('ven');
            $table->dropColumn('sam');
            $table->dropColumn('dim');
            $table->dropColumn('date_debut');
            $table->dropColumn('date_fin');
        });
    }
};
