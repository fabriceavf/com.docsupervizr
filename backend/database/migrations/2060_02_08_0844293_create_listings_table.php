<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatelistingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        DB::statement('DROP VIEW IF EXISTS listings');
        DB::statement("CREATE VIEW listings AS
                   SELECT
                    CONCAT(users.id,'-',listingsjours.id) as id,
                    listingsjours.date as date,
                    users.id as id_user,
                    users.name as name,
                    users.nom as nom,
                    users.prenom as prenom,
                    users.matricule as matricule,
                    users.num_badge as num_badge,
                    users.actif_id as actif_id,
                    users.nationalite_id as nationalite_id,
                    users.contrat_id as contrat_id,
                    users.direction_id as direction_id,
                    users.categorie_id as categorie_id,
                    users.echelon_id as echelon_id,
                    users.sexe_id as sexe_id,
                    users.matrimoniale_id as matrimoniale_id,
                    users.poste_id as poste_id,
                    users.ville_id as ville_id,
                    users.zone_id as zone_id,
                    users.situation_id as situation_id,
                    users.balise_id as balise_id,
                    users.fonction_id as fonction_id,
                    users.emp_code as emp_code,
                    users.online_id as online_id,
                    users.type_id as type_id,
                    users.faction_id as faction_id,
                    listingsetats.present as present,
                    sites.id as site_id,
                    sites.client_id as client_id,
                    listingsjours.id as id_date,
                    listingsetats.deleted_at as deleted_at

                   FROM `listingsjours`
                   JOIN `listingsetats` ON listingsetats.listingsjour_id=listingsjours.id
                   JOIN `users` ON listingsetats.user_id=users.id
                   LEFT JOIN `postes` ON postes.id=users.poste_id
                   LEFT JOIN `sites` ON postes.site_id=sites.id
                   ;
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
        DB::statement('DROP VIEW IF EXISTS listings');
    }
}
