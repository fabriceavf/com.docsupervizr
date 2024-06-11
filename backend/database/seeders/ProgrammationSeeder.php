<?php

namespace Database\Seeders;

use App\Models\Programmation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgrammationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $superviser=\DB::table('users')->where('type_id',2)->first();
//        $usersSelect=\DB::table('users')->where('type_id',2)->limit(20)->get();
//        for($i = 45 ; $i <= 52 ; $i++){
//            $etat='En cours';
//            $p5 = Programmation::create([
//                'semaine' => "2022-W$i",
//                'user_id' => $superviser->id,
//                'tache_id' => "5",
//                'statut' => $etat,
//            ]);
//            foreach ($usersSelect as $selectioner){
//                //                dd($selectioner);
//
//                $p5->programmes()->createMany([
//                    [
//                        'dimanche' => "7",
//                        'lundi' => "7",
//                        'mardi' => "7",
//                        'mercredi' => "7",
//                        'jeudi' => "7",
//                        'vendredi' => "7",
//                        'samedi' => "7",
//                        'user_id' =>$selectioner->id,
//                    ]
//                ]);
//
//            }
//        }
//        for($i = 1 ; $i < 10 ; $i++){
//            $etat='En cours';
//            if($i>2){
//                $etat='En cours';
//            }
//            $p5 = Programmation::create([
//                'semaine' => "2023-W0$i",
//                'user_id' => $superviser->id,
//                'tache_id' => "5",
//                'statut' => $etat,
//            ]);
//            foreach ($usersSelect as $selectioner){
//                //                dd($selectioner);
//
//                $p5->programmes()->createMany([
//                    [
//                        'dimanche' => "7",
//                        'lundi' => "7",
//                        'mardi' => "7",
//                        'mercredi' => "7",
//                        'jeudi' => "7",
//                        'vendredi' => "7",
//                        'samedi' => "7",
//                        'user_id' =>$selectioner->id,
//                    ]
//                ]);
//
//            }
//
//        }


    }
}
