<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FacturationImport implements ToCollection, WithChunkReading, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        $provinceCodeId = 10;
        $provinceLibelleId = 11;
        $zoneCodeId = 8;
        $zoneLibelleId = 9;
        $clientCodeId = 4;
        $clientLibelleId = 2;
        $siteCodeId = 15;
        $siteLibelleId = 16;
        $contratsclientCodeId = 12;
        $nbrsAgentsCodeId = 1;
        $factionCodeId = 23;
        $posteCodeId = 17;
        $posteLibelleId = 18;
        $joursLibelleId = 24;
        foreach ($collection->toArray() as $key => $data) {

            if ($data[3] != 'Date MEP') {


                $provinceData = [
                    'code' => $data[$provinceCodeId],
                    'libelle' => $data[$provinceLibelleId],
                    'created_at' => now()
                ];
                DB::table('provinces')->updateOrInsert(['identifiants_sadge' => $data[$provinceCodeId]], $provinceData);
                $newProvince = DB::table('provinces')->where('identifiants_sadge', $data[$provinceCodeId])->first();

                $zonesData = [
                    'code' => $data[$zoneCodeId],
                    'libelle' => $data[$zoneLibelleId],
                    'province_id' => $newProvince->id,
                    'created_at' => now()
                ];
                DB::table('zones')->updateOrInsert(['identifiants_sadge' => $data[$zoneCodeId]], $zonesData);
                $newZone = DB::table('zones')->where('identifiants_sadge', $data[$zoneCodeId])->first();


                $clientData = [
                    'code' => $data[$clientCodeId],
                    'libelle' => $data[$clientLibelleId],
                    'created_at' => now()
                ];
                DB::table('clients')->updateOrInsert(['identifiants_sadge' => $data[$clientCodeId]], $clientData);
                $newClient = DB::table('clients')->where('identifiants_sadge', $data[$clientCodeId])->first();


                $contratsclientData = [
                    'client_id' => $newClient->id,
                    'libelle' => $data[$contratsclientCodeId],
//                    'created_at'=>now()
                ];

                $identifiants_sadge = $data[$contratsclientCodeId];
                $identifiants_sadge = strval($identifiants_sadge);
                DB::table('contratsclients')->updateOrInsert(['identifiants_sadge' => $identifiants_sadge], $contratsclientData, ['created_at' => date('Y-m-d H:i:s')]);
                $newContratsclient = DB::table('contratsclients')->where('identifiants_sadge', $identifiants_sadge)->first();
//                dd($newContratsclient);


                $siteData = [
//                    'code'=>$data[$siteCodeId],
                    'libelle' => $data[$siteLibelleId],
                    'client_id' => $newClient->id,
                    'zone_id' => $newZone->id,
                    'created_at' => now()
                ];
                $identifiants_sadge = $newClient->id . "-" . $data[$siteCodeId];
                DB::table('sites')->updateOrInsert(['identifiants_sadge' => $identifiants_sadge], $siteData);


                $newSite = DB::table('sites')->where('identifiants_sadge', $identifiants_sadge)->first();

//                dd($newZone,$newSite);
                if (empty($newContratsclient->id)) {
                    dd($newContratsclient);
                }


                $faction = 'jour';
                if (Str::is('*nuit*', $data[$factionCodeId])) {
                    $faction = 'nuit';
                }

                $posteJours = explode('J', $data[$joursLibelleId])[0];
                $posteData = [
                    'code' => $data[$posteCodeId],
                    'libelle' => $data[$posteLibelleId] ?? "",
                    'jours' => $posteJours,
                    'site_id' => $newSite->id,
                    'contratsclient_id' => $newContratsclient->id,
                    "max" . $faction . 's' => $data[$nbrsAgentsCodeId],
                    'created_at' => now()
                ];
                $identifiants_sadge = $newClient->code . "-" . $newSite->identifiants_sadge . '-' . $data[$posteCodeId];
                DB::table('postes')->updateOrInsert(['identifiants_sadge' => $identifiants_sadge], $posteData);
                $newPoste = DB::table('postes')->where('identifiants_sadge', $identifiants_sadge)->first();


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
