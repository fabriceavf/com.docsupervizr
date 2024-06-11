<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BadgeImport implements ToCollection, WithChunkReading, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        $matriculeCodeId = 1;
        $matriculeLibelleId = 1;

        $badgeCodeId = 3;
        $badgeLibelleId = 3;


        foreach ($collection->toArray() as $key => $data) {

            if ($data[1] != 'MAT') {
                $matricule = strval(Str::padLeft($data[$matriculeCodeId], 6, '0'));
                $badge = strval($data[$badgeCodeId]);
                if (!empty($badge)) {
                    dump('mise a jour ===>', $badge);
                    DB::table('users')->where('matricule', $matricule)->update(['num_badge' => $badge]);
                }
            } else {
                dump($key, $data);
            }


        }


    }


    public function chunkSize(): int
    {
        return 10;
    }
}
