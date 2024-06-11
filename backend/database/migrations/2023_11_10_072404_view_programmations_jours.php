<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        $query="
        SELECT GROUP_CONCAT( DISTINCT DATE(programmes.debut_prevu) SEPARATOR ',' ) as debut,
               GROUP_CONCAT( DISTINCT DATE(programmes.fin_prevu) SEPARATOR ',' ) as fin,
               GROUP_CONCAT( DISTINCT users.matricule SEPARATOR ',' ) as users,
               programmationsusers.programmation_id as programmation_id
        FROM programmes
        JOIN programmationsusers ON programmationsusers.id = programmes.programmationsuser_id
        JOIN users ON programmationsusers.user_id = users.id
        GROUP BY programmationsusers.programmation_id;";
        DB::statement('DROP VIEW IF EXISTS programmationsdetails');
        DB::statement("CREATE VIEW programmationsdetails AS $query");

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
        DB::statement('DROP VIEW IF EXISTS programmationsdetails');
    }
};
