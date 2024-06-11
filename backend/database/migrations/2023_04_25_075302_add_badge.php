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
        Schema::table('badges',function (Blueprint $table) {
            $table->string('js')->nullable();
            $table->string('libelle')->nullable();
            $table->string('css')->nullable();
            $table->string('node_version')->nullable();
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
        Schema::table('badges',function (Blueprint $table) {
            $table->dropColumn('js');
            $table->dropColumn('libelle');
            $table->dropColumn('css');
            $table->dropColumn('node_version');
        });
    }
};
