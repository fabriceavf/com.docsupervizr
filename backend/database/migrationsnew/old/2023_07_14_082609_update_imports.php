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
        Schema::table('imports', function (Blueprint $table) {
            $table->dropColumn('fichiers');
        });
        Schema::table('imports', function (Blueprint $table) {
            $table->string('file');
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

        Schema::table('imports', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('imports', function (Blueprint $table) {
            $table->string('fichiers');
        });
    }
};
