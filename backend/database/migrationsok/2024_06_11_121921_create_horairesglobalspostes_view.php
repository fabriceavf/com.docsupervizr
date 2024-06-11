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
        DB::statement("CREATE VIEW `horairesglobalspostes` AS select `sobraga_backend`.`horaires`.`id` AS `id`,concat(`sobraga_backend`.`postes`.`libelle`,' / ',`sobraga_backend`.`sites`.`libelle`,' / ',`sobraga_backend`.`clients`.`libelle`) AS `libelle`,concat(`sobraga_backend`.`horaires`.`libelle`,' ( ',`sobraga_backend`.`horaires`.`debut`,' - ',`sobraga_backend`.`horaires`.`fin`,' )') AS `horaire` from (((`sobraga_backend`.`horaires` join `sobraga_backend`.`postes` on(`sobraga_backend`.`horaires`.`parentId` = `sobraga_backend`.`postes`.`id` and `sobraga_backend`.`horaires`.`parent` = 'poste')) join `sobraga_backend`.`sites` on(`sobraga_backend`.`postes`.`site_id` = `sobraga_backend`.`sites`.`id`)) join `sobraga_backend`.`clients` on(`sobraga_backend`.`sites`.`client_id` = `sobraga_backend`.`clients`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `horairesglobalspostes`");
    }
};
