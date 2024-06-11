<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $query = "SELECT
COUNT(transactions.id) as transactions_totals,
GROUP_CONCAT( `id` SEPARATOR ',' ) as transactions_id,
GROUP_CONCAT( `punch_time` SEPARATOR ',' ) as transactions_heures,
                    matricule,
                    punch_date as date
                    FROM transactions
                    WHERE matricule IS NOT NULL GROUP BY transactions.punch_date,matricule;";

        try{
            DB::statement('DROP VIEW IF EXISTS transactionsuserssyntheses');
            DB::statement("CREATE VIEW transactionsuserssyntheses AS $query");
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
        DB::statement('DROP VIEW IF EXISTS transactionsuserssyntheses');
    }
};
