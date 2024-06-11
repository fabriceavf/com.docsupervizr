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
        Schema::table('programmations', function (Blueprint $table) {
            $table->unsignedBigInteger('poste_id')->nullable()->default(0);
            $table->string('faction')->nullable();
            $table->string('etats')->nullable();
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
            $table->dropColumn('poste_id');
            $table->dropColumn('faction');
            $table->dropColumn('etats');
        });
    }
};
