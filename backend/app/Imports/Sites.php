<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class Sites implements ToCollection, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        $clientCodeId = 0;
        $clientLibelleId = 1;

        $allClients = [];
        $duplicate = [];
        foreach ($collection->toArray() as $key => $data) {


            if ($data[1] != 'Raison sociale') {
                $clientData = [
                    'code' => strval($data[$clientCodeId]),
                    'libelle' => strval($data[$clientLibelleId]),
                    'created_at' => now()
                ];
                DB::table('clients')->updateOrInsert([
                    'identifiants_sadge' => strval($data[$clientCodeId])
                ], $clientData);
                if (in_array($data[$clientCodeId], $allClients)) {
                    $duplicate[] = $data[$clientCodeId];
                }
                $allClients[] = $data[$clientCodeId];

            } else {
                dump($key, $data);
            }
        }


        $nonRepertorier = DB::table('clients')->whereIn('code', $allClients)->get();
        $duplicate = array_unique($duplicate);
        $duplicate = implode(',', $duplicate);
        dd($nonRepertorier, $allClients, $duplicate);
    }


}
