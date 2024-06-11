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
        DB::statement("CREATE VIEW `programmationsdetails` AS select group_concat(distinct cast(`sobraga_backend`.`programmes`.`debut_prevu` as date) separator ',') AS `debut`,group_concat(distinct cast(`sobraga_backend`.`programmes`.`fin_prevu` as date) separator ',') AS `fin`,group_concat(distinct `sobraga_backend`.`users`.`matricule` separator ',') AS `users`,`sobraga_backend`.`programmationsusers`.`programmation_id` AS `programmation_id` from ((`sobraga_backend`.`programmes` join `sobraga_backend`.`programmationsusers` on(`sobraga_backend`.`programmationsusers`.`id` = `sobraga_backend`.`programmes`.`programmationsuser_id`)) join `sobraga_backend`.`users` on(`sobraga_backend`.`programmationsusers`.`user_id` = `sobraga_backend`.`users`.`id`)) group by `sobraga_backend`.`programmationsusers`.`programmation_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `programmationsdetails`");
    }
};
