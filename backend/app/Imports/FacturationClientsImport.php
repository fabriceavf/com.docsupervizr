<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class FacturationClientsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        DB::table('zones')->truncate();
        DB::table('provinces')->truncate();

        $provinceCodeId = 6;
        $provinceLibelleId = 7;
        $zoneCodeId = 10;
        $zoneLibelleId = 11;
        foreach ($collection->toArray() as $key => $data) {

            if ($key != 0) {
                $provinceData = [
                    'code' => $data[$provinceCodeId],
                    'libelle' => $data[$provinceLibelleId],
                    'created_at' => now()
                ];
                DB::table('provinces')->updateOrInsert(['identifiants_sadge' => $data[$provinceCodeId]],
                    $provinceData
                );
                $newProvince = DB::table('provinces')->where('identifiants_sadge', $data[$provinceCodeId])->first();

                $zonesData = [
                    'code' => $data[$zoneCodeId],
                    'libelle' => $data[$zoneLibelleId],
                    'province_id' => $newProvince->id,
                    'created_at' => now()
                ];
                DB::table('zones')->updateOrInsert(['identifiants_sadge' => $data[$zoneCodeId]],
                    $zonesData
                );


                dd($key, $data);

            } else {
                dump($key, $data);
            }
        }
//       dd($collection->first());
    }
}
