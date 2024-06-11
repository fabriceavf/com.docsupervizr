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
            $table->text('lun')->default(0)->nullable();
            $table->text('mar')->default(0)->nullable();
            $table->text('mer')->default(0)->nullable();
            $table->text('jeu')->default(0)->nullable();
            $table->text('ven')->default(0)->nullable();
            $table->text('sam')->default(0)->nullable();
            $table->text('dim')->default(0)->nullable();
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
            $table->dropColumn('lun');
            $table->dropColumn('mar');
            $table->dropColumn('mer');
            $table->dropColumn('jeu');
            $table->dropColumn('ven');
            $table->dropColumn('sam');
            $table->dropColumn('dim');
        });
    }
};
