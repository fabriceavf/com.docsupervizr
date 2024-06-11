<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        $query = "SELECT
COUNT(programmes.id) as transactions_totals,
 horaires.parentId as poste_id,
GROUP_CONCAT( `programmes`.`id` SEPARATOR ',' ) as transactions_id,
GROUP_CONCAT( `programmes`.`id` SEPARATOR ',' ) as transactions_heures,
DATE(programmes.date) as date
FROM programmes
JOIN programmationsusers on programmes.programmationsuser_id=programmationsusers.id
JOIN programmations on programmationsusers.programmation_id=programmations.id
JOIN horaires on programmes.horaire_id=horaires.id
WHERE programmations.valider2 IS NOT NULL
AND programmes.presence_declarer_manuel ='oui'
GROUP BY programmes.date, horaires.parentId;";
        try{

            DB::statement('DROP VIEW IF EXISTS transactionspostessynthesesvacations');
            DB::statement("CREATE VIEW transactionspostessynthesesvacations AS $query");
        }catch (\Throwable $e){

        }
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
        DB::statement('DROP VIEW IF EXISTS transactionspostessyntheses');
    }
};
