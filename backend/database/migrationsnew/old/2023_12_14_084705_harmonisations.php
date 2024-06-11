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
        try{

            Schema::table('rattachements', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('site_id');
                $table->unsignedBigInteger('poste_id');
            });
        }catch (\Throwable $e){

        }
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
        Schema::table('rattachements', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('poste_id');
        });
    }
};
