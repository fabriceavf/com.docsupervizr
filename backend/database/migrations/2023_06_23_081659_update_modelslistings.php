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
            $table->dropColumn('supervizeur');
            $table->unsignedBigInteger('user_id')->nullable();
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
            $table->dropColumn('user_id');
            $table->unsignedBigInteger('supervizeur')->nullable();
        });
    }
};
