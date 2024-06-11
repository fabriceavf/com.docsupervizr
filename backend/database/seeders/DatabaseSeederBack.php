<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Http\Projets;
use App\Http\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\ClientRepository;
use Dompdf\Dompdf;
use Faker\Factory as Faker;
class DatabaseSeederBack extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Helpers::setGlobalDbInstanceEnv();
//
//
//        Projets::create('fonctionalite', <<<heredoc
//        Connecter les utilisateur a la plateforme
//        heredoc, 'Pouvoir se connecter a la plateforme');
//        Projets::create('champ', 'connections.id', "contenir lid de connections");
//        Projets::create('champ', 'connections.email', "contenir l'email de l'utilisateur connecter ");
//        Projets::create('champ', 'connections.user_id', "contenir l'id de lutilisateur connecter");
//        Projets::create('champ', 'connections.status', "contenir le status de tentative de connection de l'agent");
//        Projets::create('ihm', 'loginView', " Page qui affiche le formulaire de connections a l'utilisateur ");
//
//        $info = Projets::getDatabaseInfo();
//        $results= Utils::getStructureTable();
//        $tablesSort= $results;
//
//
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml('hello world');
//        $dompdf->setPaper('A4', 'landscape');
//        $dompdf->render();
//        $dompdf->stream();
//
//        $actions=[];
//        foreach ($tablesSort as $table => $tables) {
//            $table = $tables['name'];
//            $parents = $tables['parents'];
//            $tableSansS = Str::replaceLast('s', '', $table);
//            $className = ucfirst($tableSansS);
//            $champs = Arr::pluck($tables['champs'], 'Field');
//            $champsColler = implode(' , ',$champs);
//            $champsDescription = [];
//
//
//            $actions[]="Creer un dto ${className}Dtos avec les attributs suivants ${champsColler} pour des raison de simpliciter chacun de ces champs doit etre une chaine de charactere";
//            $actions[]="Creer une Class  ${className}Manager ";
//            foreach ($champs as $champ) {
//                $nam=ucfirst(Str::camel($champ));
//                $actions[]= "Creer une fonction get${nam} dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//                $actions[]= "Creer une fonction set${nam} dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//            }
//            $actions[]= "Creer une fonction toJson dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un json" ;
//            $actions[]= "Creer une fonction toJsonString dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un String" ;
//            $actions[]= "Creer une fonction loadDataFromJson dans la Class ${className}Manager  qui prend un json et renvoi un ${className}Dtos" ;
//            $actions[]= "Creer une fonction loadDataFromJsonString dans la Class ${className}Manager  qui prend un string et renvoi un ${className}Dtos" ;
//            $actions[]= "Creer une fonction getAllDataInDb dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//            $actions[]= "Creer une fonction getSpecificDataInDb dans la Class ${className}Manager  qui prend un tableau et renvoi un tableau de ${className}Dtos" ;
//            $actions[]= "Creer une fonction createDataInDb dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//            $actions[]= "Creer une fonction updateDataInDb dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//            $actions[]= "Creer une fonction deleteDataInDb dans la Class ${className}Manager  qui prend un ${className}Dtos et renvoi un ${className}Dtos" ;
//
//
//        }
//        dd($actions);
//        $liaisonsCroises=[];
//        foreach ($tablesSort as $table => $poid) {
//            $tables = $allTables[$table];
//            $table = $tables['name'];
//            $parents = $tables['parents'];
//            $tableSansS = Str::replaceLast('s', '', $table);
//            $className = ucfirst($tableSansS);
//            $champs = Arr::pluck($tables['champs'], 'Field');
//            $champsColler = implode(' , ',$champs);
//            $champsDescription = [];
//            foreach ($champs as $champ) {
//                $champsDescription[$champ] = "contenir les informations sur le $champ du(de la) $table ";
//            }
//
//            $champsDescription["created_at"] = "contenir les informations sur le  la date de creation  du(de la) $table ";
//            $champsDescription["updated_at"] = "contenir les informations sur le  date de modification  du(de la) $table ";
//            $champsDescription["deleted_at"] = "contenir les informations sur  la date de suppression  du(de la) $table ";
//
//            $action = [
//                'read' => "Avoir  la possibilite de consulter toutes les ${tableSansS}s presentes sur la plateforme",
//                'create' => "Avoir la possibilite de rajouter des ${tableSansS}s sur la plateforme",
//                'update' => "Avoir la possibilite de modifier les informations d'une ${tableSansS} sur la plateforme",
//                'delete' => "Avoir la possibilité de supprimer une ${tableSansS} sur la plateforme "
//            ];
//            $ihm = [
//                'read' => "${table}View",
//                'create' => "${table}Create",
//                'update' => "${table}Update",
//                'delete' => "${table}Delete"
//            ];
//            $ihmDescription = [
//                'read' => "page qui permet de voir sous forme de tableau l'ensembles des ${table} contenu sur la plateforme",
//                'create' => "page qui permet de renseigner au travers d'un formulaire les informations des ${table} qu'on veut rajouter sur la plateforme",
//                'update' => "page qui permet  au travers d'un formulaire, de voir puis de modifier au choix les informations d'un ou d'une ${table} contenu sur la plateforme",
//                'delete' => "page qui permet  de valider la suppression d'un ou d'une ${table} contenu sur la plateforme"
//            ];
//            foreach ($action as $key => $description) {
//                Projets::create('fonctionalite', <<<heredoc
//        $key $table
//        heredoc, $description);
//                Projets::create('ihm', $ihm[$key], $ihmDescription[$key]);
//                if ($key == 'read') {
//                    foreach ($champs as $champ) {
//                        Projets::create('champ', "$table.$champ", $champsDescription[$champ]);
//                    }
//                } else if ($key == 'create') {
//                    foreach ($parents as $par) {
//                        if ($tablesPoids[$table] != $tablesPoids[$par]) {
//
//                            Projets::prerequis('champ', "$par.id");
//                        } else {
//                            $liaisonsCroises[]=[$table,$par];
//
//                        }
//                    }
//                } else {
//                    foreach ($champs as $champ) {
//                        Projets::prerequis('champ', "$table.$champ");
//                    }
//                }
//            }
//        }
//
//
//        $donnees = Projets::getData();
//        foreach ($donnees as $data){
//            dump($data);
//        }
        $faker=Faker::create();
        $this->call(OauthClientsTableSeeder::class);
        $client = new ClientRepository();

        $client->createPasswordGrantClient(null, 'Default password grant client', 'http://your.redirect.path');
        $client->createPersonalAccessClient(null, 'Default personal access client', 'http://your.redirect.path');

        if( DB::table('users')->where([
                'email' => 'dev@gabontech.com',
                'type_id'=>4
            ])->count()==0){
            DB::table('users')->insert([
                'email' => 'dev@gabontech.com',
                'type_id'=>4,
                'nom' => 'Super Admin',
                'password' => Hash::make('password'),
            ]);
        }
//
//
//
//
//
//        if(DB::table('typeseffectifs')->count()==0){
//            DB::table('typeseffectifs')->insert([
//                'code'=>'SALARIES',
//                'libelle'=>'SALARIES',
//
//            ]);
//            DB::table('users')->insert([
//                'typeseffectif_id'=>1,
//                'nom' => $faker->name,
//                'prenom' => $faker->prenom,
//                'num_badge' => Hash::make('password'),
//            ]);
//        }
//
//        if(DB::table('transactions')){
//
//        }



    }
}
