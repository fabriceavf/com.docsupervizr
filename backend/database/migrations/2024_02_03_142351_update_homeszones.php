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
        Schema::table('homezones', function (Blueprint $table) {
            $table->string('effectifsjour')->default(0);
            $table->string('presentsjour')->default(0);
            $table->string('effectifsnuit')->default(0);
            $table->string('presentsnuit')->default(0);
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
        Schema::table('homezones', function (Blueprint $table) {
            $table->dropColumn('effectifsjour');
            $table->dropColumn('presentsjour');
            $table->dropColumn('effectifsnuit');
            $table->dropColumn('presentsnuit');

        });
    }
};
