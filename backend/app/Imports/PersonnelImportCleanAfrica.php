<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PersonnelImportCleanAfrica implements ToCollection, WithChunkReading, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        $directionCodeId = 7;
        $directionLibelleId = 7;

        $fonctionCodeId = 8;
        $fonctionLibelleId = 8;

        $serviceCodeId = 6;
        $serviceLibelleId = 6;

        $categorieCodeId = 11;
        $categorieLibelleId = 11;

        $echelonCodeId = 11;
        $echelonLibelleId = 11;

        $contratCodeId = 15;
        $contratLibelleId = 15;

        $sexeCodeId = 4;
        $sexeLibelleId = 4;

        $matrimonialeCodeId = 13;
        $matrimonialeLibelleId = 13;

        $matriculeCodeId = 1;
        $nomCodeId = 2;
        $prenomCodeId = 3;
        $badge = 10;

        foreach ($collection->toArray() as $key => $data) {


            if ($data[2] != 'NOMS') {
                $continue = true;


                dump($data);


                $directionData = [
//                    'code' => $data[$directionCodeId]??",
                    'code' => $data[$directionLibelleId] ?? "",
                    'libelle' => $data[$directionLibelleId] ?? "",
                    'created_at' => now()
                ];
                DB::table('directions')->updateOrInsert(['identifiants_sadge' => $data[$directionCodeId]], $directionData);
                $newDirection = DB::table('directions')->where('identifiants_sadge', $data[$directionCodeId])->first();
//                dd($newDirection);

                $servicesData = [
                    'code' => $data[$serviceCodeId] ?? "",
                    'libelle' => $data[$serviceLibelleId] ?? "",
                    'created_at' => now()
                ];
                DB::table('services')->updateOrInsert(['identifiants_sadge' => $data[$serviceCodeId]], $servicesData);
                $newService = DB::table('services')->where('identifiants_sadge', $data[$serviceCodeId])->first();

                $fonctionsData = [
                    'code' => $data[$fonctionCodeId] ?? "",
                    'libelle' => $data[$fonctionLibelleId] ?? "",
                    'service_id' => $newService->id,
                    'created_at' => now()
                ];
                DB::table('fonctions')->updateOrInsert(['identifiants_sadge' => $data[$fonctionCodeId]], $fonctionsData);
                $newFonction = DB::table('fonctions')->where('identifiants_sadge', $data[$fonctionCodeId])->first();


                $sexesData = [
                    'code' => $data[$sexeCodeId] ?? "",
                    'libelle' => $data[$sexeLibelleId] ?? "",
                    'created_at' => now()
                ];
                DB::table('sexes')->updateOrInsert(['identifiants_sadge' => $data[$sexeCodeId]], $sexesData);
                $newSexe = DB::table('sexes')->where('identifiants_sadge', $data[$sexeCodeId])->first();


                $matricule = Str::padLeft($data[$matriculeCodeId] ?? "", 6, '0');

                $userData = [

                    'nom' => $data[$nomCodeId] ?? "",
                    'prenom' => $data[$prenomCodeId] ?? "",
                    'num_badge' => $data[$badge],
//                    'date_naissance' => $data[$date_naissanceCodeId]??",
                    'direction_id' => $newDirection->id,
                    'fonction_id' => $newFonction->id,

                    'sexe_id' => $newSexe->id,
                    'type_id' => 2,
                    'actif_id' => 1,
                    'identifiants_sadge' => $matricule,
                    'updated_at' => now(),

                ];


                DB::table('users')->updateOrInsert(['matricule' => $matricule], $userData);


//                dd($key,$data);

            } else {
                dump($key, $data);
            }
        }


//       dd($collection->first());
    }


    public function chunkSize(): int
    {
        return 10;
    }
}
