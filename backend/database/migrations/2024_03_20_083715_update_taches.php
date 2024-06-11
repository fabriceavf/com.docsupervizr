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
        Schema::table('taches', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('jours')->nullable();
            $table->string('code')->nullable();
            $table->integer('maxjours')->default(0);
            $table->integer('maxnuits')->default(0);
            $table->longtext('NbrsJours')->nullable();
            $table->longtext('NbrsNuits')->nullable();
            $table->longtext('IsCouvert')->nullable();
            $table->longtext('Agentjour')->nullable();
            $table->longtext('Agentnuit')->nullable();
            $table->longtext('couvertAgentjour')->nullable();
            $table->longtext('couvertAgentnuit')->nullable();
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
        Schema::table('taches', function (Blueprint $table) {
            $table->dropColumn('jours');
            $table->dropColumn('code');
            $table->dropColumn('site_id');
            $table->dropColumn('maxjours');
            $table->dropColumn('maxnuits');
            $table->dropColumn('NbrsJours');
            $table->dropColumn('NbrsNuits');
            $table->dropColumn('IsCouvert');
            $table->dropColumn('Agentjour');
            $table->dropColumn('Agentnuit');
            $table->dropColumn('couvertAgentjour');
            $table->dropColumn('couvertAgentnuit');
        });
    }
};
