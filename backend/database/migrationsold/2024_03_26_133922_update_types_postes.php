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
        Schema::table('typespostes', function (Blueprint $table) {
            $table->integer('canCreate')->default(1);
            $table->integer('canUpdate')->default(1);
            $table->integer('canDelete')->default(1);
        });
        Schema::table('typessites', function (Blueprint $table) {
            $table->integer('canCreate')->default(1);
            $table->integer('canUpdate')->default(1);
            $table->integer('canDelete')->default(1);
        });
        Schema::table('typeseffectifs', function (Blueprint $table) {
            $table->integer('canCreate')->default(1);
            $table->integer('canUpdate')->default(1);
            $table->integer('canDelete')->default(1);
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
        //
    }
};
