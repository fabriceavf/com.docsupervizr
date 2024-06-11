<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PersonnelImport implements ToCollection, WithChunkReading, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        $directionCodeId = 1;
        $directionLibelleId = 1;

        $fonctionCodeId = 7;
        $fonctionLibelleId = 7;

        $nationaliteCodeId = 8;
        $nationaliteLibelleId = 8;

        $categorieCodeId = 11;
        $categorieLibelleId = 11;

        $echelonCodeId = 11;
        $echelonLibelleId = 11;

        $contratCodeId = 15;
        $contratLibelleId = 15;

        $sexeCodeId = 16;
        $sexeLibelleId = 16;

        $matrimonialeCodeId = 13;
        $matrimonialeLibelleId = 13;

        $matriculeCodeId = 2;
        $nomCodeId = 3;
        $prenomCodeId = 4;
        $nombre_enfantCodeId = 14;

        foreach ($collection->toArray() as $key => $data) {

            if ($data[3] != 'NOM') {
                $continue = true;


//                foreach ($data as $donne ){
//                    if(empty($donne)){
//                        $continue=false;
//                    }
//                }


                $directionData = [
//                    'code' => $data[$directionCodeId],
                    'code' => $data[$directionLibelleId],
                    'libelle' => $data[$directionLibelleId],
                    'created_at' => now()
                ];
                DB::table('directions')->updateOrInsert(['identifiants_sadge' => $data[$directionCodeId]], $directionData);
                $newDirection = DB::table('directions')->where('identifiants_sadge', $data[$directionCodeId])->first();
//                dd($newDirection);

                $fonctionsData = [
                    'code' => $data[$fonctionCodeId],
                    'libelle' => $data[$fonctionLibelleId],
                    'created_at' => now()
                ];
                DB::table('fonctions')->updateOrInsert(['identifiants_sadge' => $data[$fonctionCodeId]], $fonctionsData);
                $newFonction = DB::table('fonctions')->where('identifiants_sadge', $data[$fonctionCodeId])->first();

                $nationalitesData = [
                    'code' => $data[$nationaliteCodeId],
                    'libelle' => $data[$nationaliteLibelleId],
                    'created_at' => now()
                ];
                DB::table('nationalites')->updateOrInsert(['identifiants_sadge' => $data[$nationaliteCodeId]], $nationalitesData);
                $newNationalite = DB::table('nationalites')->where('identifiants_sadge', $data[$nationaliteCodeId])->first();

                $categoriesData = [
                    'code' => $data[$categorieCodeId],
                    'libelle' => $data[$categorieLibelleId],
                    'created_at' => now()
                ];
                DB::table('categories')->updateOrInsert(['identifiants_sadge' => $data[$categorieCodeId]], $categoriesData);
                $newCategorie = DB::table('categories')->where('identifiants_sadge', $data[$categorieCodeId])->first();

                $echelonsData = [
                    'code' => $data[$echelonCodeId],
                    'libelle' => $data[$echelonLibelleId],
                    'created_at' => now()
                ];
                DB::table('echelons')->updateOrInsert(['identifiants_sadge' => $data[$echelonCodeId]], $echelonsData);
                $newEchelon = DB::table('echelons')->where('identifiants_sadge', $data[$echelonCodeId])->first();

                $matrimonialesData = [
                    'code' => $data[$matrimonialeCodeId],
                    'libelle' => $data[$matrimonialeLibelleId],
                    'created_at' => now()
                ];
                DB::table('matrimoniales')->updateOrInsert(['identifiants_sadge' => $data[$matrimonialeCodeId]], $matrimonialesData);
                $newMatrimoniale = DB::table('matrimoniales')->where('identifiants_sadge', $data[$matrimonialeCodeId])->first();

                $contratsData = [
                    'code' => $data[$contratCodeId],
                    'libelle' => $data[$contratLibelleId],
                    'created_at' => now()
                ];
                DB::table('contrats')->updateOrInsert(['identifiants_sadge' => $data[$contratCodeId]], $contratsData);
                $newContrat = DB::table('contrats')->where('identifiants_sadge', $data[$contratCodeId])->first();

                $sexesData = [
                    'code' => $data[$sexeCodeId],
                    'libelle' => $data[$sexeLibelleId],
                    'created_at' => now()
                ];
                DB::table('sexes')->updateOrInsert(['identifiants_sadge' => $data[$sexeCodeId]], $sexesData);
                $newSexe = DB::table('sexes')->where('identifiants_sadge', $data[$sexeCodeId])->first();


                $matricule = Str::padLeft($data[$matriculeCodeId], 6, '0');

                $userData = [

                    'nom' => $data[$nomCodeId],
                    'prenom' => $data[$prenomCodeId],
                    'direction_id' => $newDirection->id,
                    'fonction_id' => $newFonction->id,
                    'nationalite_id' => $newNationalite->id,
                    'categorie_id' => $newCategorie->id,
                    'echelon_id' => $newEchelon->id,
                    'matrimoniale_id' => $newMatrimoniale->id,
                    'nombre_enfant' => $data[$nombre_enfantCodeId],
                    'contrat_id' => $newContrat->id,
                    'sexe_id' => $newSexe->id,
                    'type_id' => 2,
                    'actif_id' => 1,
                    'identifiants_sadge' => $matricule,
                    'updated_at' => now(),

                ];


                DB::table('users')->updateOrInsert(['matricule' => $matricule], $userData);

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
