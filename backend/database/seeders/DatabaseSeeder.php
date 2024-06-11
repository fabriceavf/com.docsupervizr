<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\ClientRepository;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OauthClientsTableSeeder::class);
        $client = new ClientRepository();

        $client->createPasswordGrantClient(null, 'Default password grant client', 'http://your.redirect.path');
        $client->createPersonalAccessClient(null, 'Default personal access client', 'http://your.redirect.path');
        if (DB::table('users')->where([
                'email' => 'dev@gabontech.com',
                'type_id' => 4
            ])->count() == 0) {
            DB::table('users')->insert([
                'email' => 'dev@gabontech.com',
                'type_id' => 4,
                'nom' => 'Super Admin',
                'password' => Hash::make('password'),
            ]);
//            $this->call(DirectionsTableSeeder::class);
//            $this->call(ActifsTableSeeder::class);
//            $this->call(AlarmsTableSeeder::class);
//            $this->call(AlldatasTableSeeder::class);
//            $this->call(AnalysespointeusesTableSeeder::class);
//            $this->call(ApprovisionementsTableSeeder::class);
//            $this->call(BalisesTableSeeder::class);
//            $this->call(CalendriersTableSeeder::class);
//            $this->call(CategoriesTableSeeder::class);
//            $this->call(CauseracinesTableSeeder::class);
//            $this->call(ChantiersTableSeeder::class);
//            $this->call(ClientsTableSeeder::class);
//            $this->call(ConfigurationsTableSeeder::class);
//            $this->call(ContratsTableSeeder::class);
//            $this->call(DocumentsTableSeeder::class);
//            $this->call(DoublonsPostesTableSeeder::class);
//            $this->call(EchelonsTableSeeder::class);
//            $this->call(ExportsTableSeeder::class);
//            $this->call(ExtrasdatasTableSeeder::class);
//            $this->call(FactionsTableSeeder::class);
//            $this->call(FacturationuploadsTableSeeder::class);
//            $this->call(FilesTableSeeder::class);
//            $this->call(FormsTableSeeder::class);
//            $this->call(FormschampsTableSeeder::class);
//            $this->call(GraphiquesTableSeeder::class);
//            $this->call(GroupedirectionsTableSeeder::class);
//            $this->call(GroupepermissionsTableSeeder::class);
//            $this->call(HistoriquesTableSeeder::class);
//            $this->call(HomesTableSeeder::class);
//            $this->call(ProjetsTableSeeder::class);
//            $this->call(ProvincesTableSeeder::class);
//            $this->call(SituationsTableSeeder::class);
//            $this->call(SoldablesTableSeeder::class);
//            $this->call(SupervirzclientsTableSeeder::class);
//            $this->call(SwitchsusersTableSeeder::class);
//            $this->call(TypesTableSeeder::class);
//            $this->call(TypesagentshorairesTableSeeder::class);
//            $this->call(TypeseffectifsTableSeeder::class);
//            $this->call(TypesheuresTableSeeder::class);
//            $this->call(TypesmoyenstransportsTableSeeder::class);
//            $this->call(TypespostesTableSeeder::class);
//            $this->call(TypessitesTableSeeder::class);
//            $this->call(TypestachesTableSeeder::class);
//            $this->call(TypesventilationsTableSeeder::class);
//            $this->call(VariablesTableSeeder::class);
//            $this->call(VehiculesTableSeeder::class);
//            $this->call(VillesTableSeeder::class);
//            $this->call(VoituresTableSeeder::class);
//            $this->call(WebsocketsStatisticsEntriesTableSeeder::class);
//            $this->call(ServicesTableSeeder::class);
//            $this->call(FonctionsTableSeeder::class);
//            $this->call(ContratsclientsTableSeeder::class);
//            $this->call(SitesTableSeeder::class);
//            $this->call(PointeusesTableSeeder::class);
//            $this->call(ZonesTableSeeder::class);
//            $this->call(PostesTableSeeder::class);
//            $this->call(UsersTableSeeder::class);
//            $this->call(AgentsrapportsTableSeeder::class);
//            $this->call(BadgesTableSeeder::class);
//            $this->call(CartesTableSeeder::class);
//            $this->call(ProcessusTableSeeder::class);
//            $this->call(DetailsTableSeeder::class);
//            $this->call(EcouteursTableSeeder::class);
//            $this->call(EmpreintesTableSeeder::class);
//            $this->call(LignesTableSeeder::class);
//            $this->call(EtapesTableSeeder::class);
//            $this->call(ExportsdetailsTableSeeder::class);
//            $this->call(FormsdatasTableSeeder::class);
//            $this->call(HistoriquemodelslistingsTableSeeder::class);
//            $this->call(HorairesTableSeeder::class);
//            $this->call(HorairestypespostesTableSeeder::class);
//            $this->call(HorairestypessitesTableSeeder::class);
//            $this->call(InterventionsTableSeeder::class);
//            $this->call(InterventionusersTableSeeder::class);
//            $this->call(InterventiondetailsTableSeeder::class);
//            $this->call(InterventionimagesTableSeeder::class);
//            $this->call(ListesjoursTableSeeder::class);
//            $this->call(LogsTableSeeder::class);
//            $this->call(MaterielinterventionsTableSeeder::class);
//            $this->call(MenusTableSeeder::class);
//            $this->call(PermissionsTableSeeder::class);
//            $this->call(ModelHasPermissionsTableSeeder::class);
//            $this->call(ModelHasRolesTableSeeder::class);
//            $this->call(MoyenstransportsTableSeeder::class);
//            $this->call(PassagesrondesTableSeeder::class);
//            $this->call(PastillesTableSeeder::class);
//            $this->call(PermissionsdetailsTableSeeder::class);
//            $this->call(PointsTableSeeder::class);
//            $this->call(PositionsTableSeeder::class);
//            $this->call(PresencesTableSeeder::class);
//            $this->call(TachesTableSeeder::class);
//            $this->call(ProgrammationsTableSeeder::class);
//            $this->call(RapportpostesTableSeeder::class);
//            $this->call(RessourcesTableSeeder::class);
//            $this->call(StatszonesTableSeeder::class);
//            $this->call(SupervirzclientshidesTableSeeder::class);
//            $this->call(TerminalsTableSeeder::class);
//            $this->call(LignesmoyenstransportsTableSeeder::class);
//            $this->call(DeplacementsTableSeeder::class);
//            $this->call(ControlleursaccesTableSeeder::class);
        }


    }
}
