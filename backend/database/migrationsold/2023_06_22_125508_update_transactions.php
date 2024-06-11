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

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('pointeusepostes');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('pointeusepostes')->nullable();
            $table->boolean('verification')->default(1);
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('pointeusepostes')->nullable();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('pointeusepostes')->nullable();
            $table->dropColumn('verification')->default(1);
        });
    }
};
