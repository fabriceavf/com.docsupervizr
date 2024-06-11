<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::table('activites', function (Blueprint $table) {
            $table->string('type')->default('normal');
            $table->string('etats_actuel')->nullable();
            $table->text('description_actuel')->nullable();
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
        Schema::table('activites', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('etats_actuel');
            $table->dropColumn('description_actuel');
        });
    }
};
