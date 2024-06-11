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
        DB::statement('DROP VIEW IF EXISTS transactionssyntheses');
        DB::statement("CREATE VIEW transactionssyntheses AS
                   SELECT COUNT(id) as transactions_totals,GROUP_CONCAT( `punch_time` SEPARATOR ',' ) as transactions_heures,GROUP_CONCAT( `id` SEPARATOR ',' ) as transactions_id,matricule,punch_date as date FROM transactions WHERE matricule IS NOT NULL GROUP BY matricule,punch_date;
                     ");
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
        DB::statement('DROP VIEW IF EXISTS transactionssyntheses');
    }
};
