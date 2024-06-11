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
            COUNT( DISTINCT transactions.id) as transactions_totals,
            GROUP_CONCAT( transactions.id SEPARATOR ',' ) as transactions_id,
            GROUP_CONCAT( DISTINCT transactions.matricule SEPARATOR ',' ) as transactions_matricule,
            GROUP_CONCAT( transactions.punch_time SEPARATOR ',' ) as transactions_heures,
            punch_date as date , postespointeuses.poste_id as poste_id
            FROM transactions
            JOIN postespointeuses ON transactions.pointeuse_id= postespointeuses.pointeuse_id
                                  WHERE transactions.pointeuse_id IS NOT NULL GROUP BY punch_date,postespointeuses.poste_id; ";
        try{

            DB::statement('DROP VIEW IF EXISTS transactionspostessyntheses');
            DB::statement("CREATE VIEW transactionspostessyntheses AS $query");
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
