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
        DB::statement('DROP VIEW IF EXISTS pointeusestransactions');
        DB::statement("CREATE VIEW pointeusestransactions AS
                   SELECT COUNT(id) as transactions_totals, GROUP_CONCAT( `punch_time` SEPARATOR ',' ) as transactions_heures, GROUP_CONCAT( `id` SEPARATOR ',' ) as transactions_id, punch_date as date, area_alias as pointeuse FROM transactions WHERE transactions.deleted_at IS NULL GROUP BY punch_date, area_alias;  ");
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
        DB::statement('DROP VIEW IF EXISTS pointeusestransactions');
    }
};
