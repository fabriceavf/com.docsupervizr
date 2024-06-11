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
        Schema::table('statszones', function (Blueprint $table) {
            $table->string('modelslistingnuit1')->nullable();
            $table->string('modelslistingnuit2')->nullable();
            $table->string('modelslistingnuit3')->nullable();
            $table->string('modelslistingjour1')->nullable();
            $table->string('modelslistingjour2')->nullable();
            $table->string('modelslistingjour3')->nullable();
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
        Schema::table('statszones', function (Blueprint $table) {
            $table->dropColumn('modelslistingnuit1');
            $table->dropColumn('modelslistingnuit2');
            $table->dropColumn('modelslistingnuit3');
            $table->dropColumn('modelslistingjour1');
            $table->dropColumn('modelslistingjour2');
            $table->dropColumn('modelslistingjour3');
        });
    }
};
