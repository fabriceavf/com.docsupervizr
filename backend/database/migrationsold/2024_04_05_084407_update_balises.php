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
        Schema::table('balises', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('course');
            $table->dropColumn('speed');
            $table->dropColumn('icon_color');
            $table->dropColumn('heure');
            $table->dropColumn('libelle');
            $table->dropColumn('ref');
        });
        Schema::table('balises', function (Blueprint $table) {
            $table->string('libelle')->nullable();
            $table->string('ref')->nullable();
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
        Schema::table('balises', function (Blueprint $table) {
            $table->dropColumn('libelle');
            $table->dropColumn('ref');
        });
        Schema::table('balises', function (Blueprint $table) {
            $table->string('lat');
            $table->string('lng');
            $table->string('course');
            $table->string('speed');
            $table->string('icon_color');
            $table->string('heure');
            $table->string('libelle')->nullable();
            $table->string('ref')->nullable();
        });


    }
};
