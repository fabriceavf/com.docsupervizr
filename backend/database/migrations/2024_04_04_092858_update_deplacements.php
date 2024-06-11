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
        Schema::table('deplacements', function (Blueprint $table) {
            $table->dropColumn('moyenstransport');
            $table->dropColumn('ligne');
        });
        Schema::table('deplacements', function (Blueprint $table) {
            $table->unsignedBigInteger('moyenstransport_id')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
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
        Schema::table('deplacements', function (Blueprint $table) {
            $table->dropColumn('moyenstransport_id');
            $table->dropColumn('ligne_id');
        });
        Schema::table('deplacements', function (Blueprint $table) {
            $table->string('moyenstransport')->nullable();
            $table->string('ligne')->nullable();
        });
    }
};
