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
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('user_id_4')->nullable();
        });
        Schema::table('programmations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('user_id_4')->nullable();
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
        Schema::table('programmations', function (Blueprint $table) {
            $table->dropColumn('user_id_3');
            $table->dropColumn('user_id_4');
        });
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->dropColumn('user_id_3');
            $table->dropColumn('user_id_4');
        });
    }
};
