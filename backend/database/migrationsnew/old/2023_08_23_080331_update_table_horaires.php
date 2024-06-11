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
        Schema::table('horaires', function (Blueprint $table) {
            $table->string('parent')->nullable();
            $table->string('parentId')->nullable();
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

        Schema::table('horaires', function (Blueprint $table) {
            $table->dropColumn('parent');
            $table->dropColumn('parentId');
        });
    }
};
