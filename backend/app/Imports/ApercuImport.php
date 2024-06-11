<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ApercuImport implements ToCollection, WithChunkReading, WithCalculatedFormulas
{

    public function __construct($table, $limit)
    {
        $this->table = $table;
        $this->limit = $limit;
        $this->counter = 0;

    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {


        foreach ($collection->toArray() as $key => $data) {

            if ($this->counter < $this->limit) {
                DB::table('extrasdatas')->insert(
                    [
                        'cle' => $this->table,
                        'valeur' => json_encode($data)
                    ]
                );
            } else {
                if ($this->counter % 10 == 0) {
                    $data = 1 / 0;
                }
            }

            $this->counter++;


        }

    }


    public function chunkSize(): int
    {
        return 5;
    }
}
