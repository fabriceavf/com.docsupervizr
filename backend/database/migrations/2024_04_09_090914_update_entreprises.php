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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('badge_avant')->nullable();
            $table->string('badge_arriere')->nullable();
            $table->string('modules')->nullable();
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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn('badge_avant');
            $table->dropColumn('badge_arriere');
            $table->dropColumn('modules');
        });
    }
};
