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
        Schema::table('activites', function (Blueprint $table) {
            $table->dropColumn('description');

        });
        Schema::table('activites', function (Blueprint $table) {
            $table->text('description')->nullable();

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
        Schema::table('activites', function (Blueprint $table) {
            $table->dropColumn('description');

        });
        Schema::table('activites', function (Blueprint $table) {
            $table->string('description')->nullable();

        });
    }
};
