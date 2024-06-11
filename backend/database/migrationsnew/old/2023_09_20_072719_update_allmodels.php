<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('activites', function (Blueprint $table) {
            $table->longtext('ParentElements')->nullable();
            $table->longtext('AllEtats')->nullable();
            $table->longtext('CanUpdate')->nullable();
            $table->longtext('IsCreateByMe')->nullable();
            $table->longtext('IsWorkForMe')->nullable();
            $table->longtext('Status')->nullable();
            $table->longtext('Createur')->nullable();
        });
        Schema::table('besoins', function (Blueprint $table) {
            $table->longtext('Child')->nullable();
            $table->longtext('ChildPrevu')->nullable();
            $table->longtext('ChildImprevu')->nullable();
            $table->longtext('ChildReussi')->nullable();
            $table->longtext('ChildBloquer')->nullable();
        });
        Schema::table('contratsclients', function (Blueprint $table) {
            $table->longtext('AllSites')->nullable();
        });
        Schema::table('cruds', function (Blueprint $table) {
            $table->longtext('Detail')->nullable();
        });
        Schema::table('modelslistings', function (Blueprint $table) {
            $table->longtext('Generate')->nullable();
        });
        Schema::table('pointeuses', function (Blueprint $table) {
            $table->longtext('postes')->nullable();
            $table->longtext('Taches')->nullable();
        });
        Schema::table('postes', function (Blueprint $table) {
            $table->longtext('NbrsJours')->nullable();
            $table->longtext('NbrsNuits')->nullable();
            $table->longtext('IsCouvert')->nullable();
            $table->longtext('pointeuses')->nullable();
            $table->longtext('Agentjour')->nullable();
            $table->longtext('Agentnuit')->nullable();
            $table->longtext('couvertAgentjour')->nullable();
            $table->longtext('couvertAgentnuit')->nullable();
        });
        Schema::table('programmations', function (Blueprint $table) {
            $table->longtext('Allclients')->nullable();
            $table->longtext('AllDatesInRange')->nullable();
            $table->longtext('Presents')->nullable();
            $table->longtext('Abscents')->nullable();
            $table->longtext('Presentsid')->nullable();
            $table->longtext('Abscentsid')->nullable();
        });
        Schema::table('programmes', function (Blueprint $table) {
            $table->longtext('user')->nullable();
            $table->longtext('DayStatut')->nullable();
            $table->longtext('Remplacantuser')->nullable();
            $table->longtext('PresencesDeclarer')->nullable();
            $table->longtext('AbscencesDeclarer')->nullable();
            $table->longtext('EtatsDeclarer')->nullable();
        });
        Schema::table('programmes', function (Blueprint $table) {
            $table->longtext('Totalpresent')->nullable();
            $table->longtext('J1')->nullable();
            $table->longtext('J2')->nullable();
            $table->longtext('J3')->nullable();
            $table->longtext('J4')->nullable();
            $table->longtext('J5')->nullable();
            $table->longtext('J6')->nullable();
            $table->longtext('J7')->nullable();
            $table->longtext('J8')->nullable();
            $table->longtext('J9')->nullable();
            $table->longtext('J10')->nullable();
            $table->longtext('J11')->nullable();
            $table->longtext('J12')->nullable();
            $table->longtext('J13')->nullable();
            $table->longtext('J14')->nullable();
            $table->longtext('J15')->nullable();
            $table->longtext('J16')->nullable();
            $table->longtext('J17')->nullable();
            $table->longtext('J18')->nullable();
            $table->longtext('J19')->nullable();
            $table->longtext('J20')->nullable();
            $table->longtext('J21')->nullable();
            $table->longtext('J22')->nullable();
            $table->longtext('J23')->nullable();
            $table->longtext('J24')->nullable();
            $table->longtext('J25')->nullable();
            $table->longtext('J26')->nullable();
            $table->longtext('J27')->nullable();
            $table->longtext('J28')->nullable();
            $table->longtext('J29')->nullable();
            $table->longtext('J30')->nullable();
            $table->longtext('J31')->nullable();
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->longtext('NbrsJours')->nullable();
            $table->longtext('NbrsNuits')->nullable();
        });
        Schema::table('taches', function (Blueprint $table) {
            $table->longtext('Pointeuses')->nullable();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->longtext('TachesPotentiels')->nullable();
            $table->longtext('PostesPotentiels')->nullable();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->longtext('TotalPostes')->nullable();
            $table->longtext('TotalPostescouvert')->nullable();
            $table->longtext('TotalPostesnoncouvert')->nullable();
            $table->longtext('TotalPostessouscouvert')->nullable();
        });
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
        Schema::table('activites', function (Blueprint $table) {
            $table->dropColumn('ParentElements');
            $table->dropColumn('AllEtats');
            $table->dropColumn('CanUpdate');
            $table->dropColumn('IsCreateByMe');
            $table->dropColumn('IsWorkForMe');
            $table->dropColumn('Status');
            $table->dropColumn('Createur');
        });

        Schema::table('besoins', function (Blueprint $table) {
            $table->dropColumn('Child');
            $table->dropColumn('ChildPrevu');
            $table->dropColumn('ChildImprevu');
            $table->dropColumn('ChildReussi');
            $table->dropColumn('ChildBloquer');
        });

        Schema::table('contratsclients', function (Blueprint $table) {
            $table->dropColumn('AllSites');
        });

        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn('Detail');
        });

        Schema::table('modelslistings', function (Blueprint $table) {
            $table->dropColumn('Generate');
        });

        Schema::table('pointeuses', function (Blueprint $table) {
            $table->dropColumn('postes');
            $table->dropColumn('Taches');
        });

        Schema::table('postes', function (Blueprint $table) {
            $table->dropColumn('NbrsJours');
            $table->dropColumn('NbrsNuits');
            $table->dropColumn('IsCouvert');
            $table->dropColumn('pointeuses');
            $table->dropColumn('Agentjour');
            $table->dropColumn('Agentnuit');
            $table->dropColumn('couvertAgentjour');
            $table->dropColumn('couvertAgentnuit');
        });

        Schema::table('programmations', function (Blueprint $table) {
            $table->dropColumn('Allclients');
            $table->dropColumn('AllDatesInRange');
            $table->dropColumn('Presents');
            $table->dropColumn('Abscents');
            $table->dropColumn('Presentsid');
            $table->dropColumn('Abscentsid');
        });

        Schema::table('programmes', function (Blueprint $table) {
            $table->dropColumn('user');
            $table->dropColumn('DayStatut');
            $table->dropColumn('Remplacantuser');
            $table->dropColumn('PresencesDeclarer');
            $table->dropColumn('AbscencesDeclarer');
            $table->dropColumn('EtatsDeclarer');
            $table->dropColumn('Totalpresent');
            $table->dropColumn('J1');
            $table->dropColumn('J2');
            $table->dropColumn('J3');
            $table->dropColumn('J4');
            $table->dropColumn('J5');
            $table->dropColumn('J6');
            $table->dropColumn('J7');
            $table->dropColumn('J8');
            $table->dropColumn('J9');
            $table->dropColumn('J10');
            $table->dropColumn('J11');
            $table->dropColumn('J12');
            $table->dropColumn('J13');
            $table->dropColumn('J14');
            $table->dropColumn('J15');
            $table->dropColumn('J16');
            $table->dropColumn('J17');
            $table->dropColumn('J18');
            $table->dropColumn('J19');
            $table->dropColumn('J20');
            $table->dropColumn('J21');
            $table->dropColumn('J22');
            $table->dropColumn('J23');
            $table->dropColumn('J24');
            $table->dropColumn('J25');
            $table->dropColumn('J26');
            $table->dropColumn('J27');
            $table->dropColumn('J28');
            $table->dropColumn('J29');
            $table->dropColumn('J30');
            $table->dropColumn('J31');
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('NbrsJours');
            $table->dropColumn('NbrsNuits');
        });

        Schema::table('taches', function (Blueprint $table) {
            $table->dropColumn('Pointeuses');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('TachesPotentiels');
            $table->dropColumn('PostesPotentiels');
            $table->dropColumn('TotalPostes');
            $table->dropColumn('TotalPostescouvert');
            $table->dropColumn('TotalPostesnoncouvert');
            $table->dropColumn('TotalPostessouscouvert');
        });
    }
};
