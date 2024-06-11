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
        $query = "    SELECT
    horaires.id as id,
    CONCAT(postes.libelle , ' / ' ,sites.libelle ,' / ' , clients.libelle) as libelle ,
    CONCAT(horaires.libelle , ' ( ' ,horaires.debut ,' - ' , horaires.fin ,' )') as horaire

    FROM horaires
    JOIN postes ON horaires.parentId=postes.id AND horaires.parent='poste'
    JOIN sites ON postes.site_id=sites.id
    JOIN clients ON sites.client_id=clients.id;  ";

        DB::statement('DROP VIEW IF EXISTS horairesglobalspostes');
        DB::statement("CREATE VIEW horairesglobalspostes AS $query");
        $query = "    SELECT
                horaires.id as id,
                CONCAT(taches.libelle , ' / ' ,villes.libelle)  as libelle ,
                CONCAT(horaires.libelle , ' ( ' ,horaires.debut ,' - ' , horaires.fin ,' )') as horaire

                FROM horaires
                JOIN taches ON horaires.parentId=taches.id AND horaires.parent='tache'
                JOIN villes ON taches.ville_id=villes.id  ;   ";

        DB::statement('DROP VIEW IF EXISTS horairesglobalstaches');
        DB::statement("CREATE VIEW horairesglobalstaches AS $query");

        $query = "SELECT
        postes.id as id,
        CONCAT(postes.libelle , ' / ' ,sites.libelle ,' / ' , clients.libelle) as libelle,
        CONCAT(postes.identifiants_sadge , ' / ' ,sites.identifiants_sadge ,' / ' , clients.code) as code,
        sites.libelle as site,
        zones.libelle as zone
        FROM postes
        JOIN sites ON postes.site_id=sites.id
        JOIN zones ON sites.zone_id=zones.id
        JOIN clients ON sites.client_id=clients.id; ";



        DB::statement('DROP VIEW IF EXISTS postesglobals');
        DB::statement("CREATE VIEW postesglobals AS $query");

        $query = "SELECT
        sites.id as id,
        sites.created_at as created_at,
        sites.deleted_at as deleted_at,
        CONCAT(sites.libelle , ' / ' , clients.libelle) as libelle,

        CONCAT(sites.libelle , ' / ' , clients.libelle) as Selectlabel
        FROM sites
        JOIN clients ON sites.client_id=clients.id; ";

        DB::statement('DROP VIEW IF EXISTS sitesglobals');
        DB::statement("CREATE VIEW sitesglobals AS $query");
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
        DB::statement('DROP VIEW IF EXISTS sitesglobals');
        DB::statement('DROP VIEW IF EXISTS postesglobals');
        DB::statement('DROP VIEW IF EXISTS horairesglobalstaches');
        DB::statement('DROP VIEW IF EXISTS horairesglobalspostes');
    }
};
