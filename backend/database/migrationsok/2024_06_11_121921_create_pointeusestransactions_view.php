<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `pointeusestransactions` AS select count(`sobraga_backend`.`transactions`.`id`) AS `transactions_totals`,group_concat(`sobraga_backend`.`transactions`.`punch_time` separator ',') AS `transactions_heures`,group_concat(`sobraga_backend`.`transactions`.`id` separator ',') AS `transactions_id`,`sobraga_backend`.`transactions`.`punch_date` AS `date`,`sobraga_backend`.`transactions`.`area_alias` AS `pointeuse` from `sobraga_backend`.`transactions` where `sobraga_backend`.`transactions`.`deleted_at` is null group by `sobraga_backend`.`transactions`.`punch_date`,`sobraga_backend`.`transactions`.`area_alias`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `pointeusestransactions`");
    }
};
