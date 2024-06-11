<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $query="SELECT * FROM horairesglobalstaches UNION SELECT * FROM horairesglobalspostes";

        DB::statement('DROP VIEW IF EXISTS horairesglobals');
        DB::statement("CREATE VIEW horairesglobals AS $query");
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
        Schema::dropIfExists('horaires_globals');
    }
};
