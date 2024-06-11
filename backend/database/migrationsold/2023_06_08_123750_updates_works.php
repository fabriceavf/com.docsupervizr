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
        Schema::table('works', function (Blueprint $table) {
            $table->timestamp('debut')->nullable();
            $table->timestamp('fin')->nullable();
            $table->uuid('groupe')->nullable();
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

        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('debut');
            $table->dropColumn('fin');
            $table->dropColumn('groupe');
        });
    }
};
