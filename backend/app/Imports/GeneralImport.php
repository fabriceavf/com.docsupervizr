<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Throwable;

class GeneralImport implements ToCollection, WithChunkReading, WithCalculatedFormulas
{

    public function __construct($data, $table = 'users')
    {
        $this->data = $data;
        $this->colonnes = 0;
        $this->parametres = [];
        $this->table = $this->data->type;
        $this->usersTable = $table;
        $this->count = 0;
        $params = json_decode($this->data->liaisons);
        foreach ($params as $key => $par) {
            if (intval($par->key) != 0) {
                $this->parametres[Str::camel($par->label)] = intval($par->key) - 1;

            }
        }
    }


    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        $table = $this->table;
        $parametres = $this->parametres;

        if ($table == 'agents' || $table == 'agents-one') {

            $type_id = $table == 'agents' ? 2 : 3;
            foreach ($collection->toArray() as $key => $data) {
                try {
                    if ($this->colonnes != 0) {


                    }

                    $this->colonnes++;
                    $this->count++;
                } catch (Throwable $e) {

                }


            }
        }


    }

    public function chunkSize(): int
    {
        return 100;
    }

    private function getCode($name, $params, $data)
    {
        $code = false;
        $defaultCode = 'code' . ucfirst($name);
        $alternativetCode = $name;
        if (array_key_exists($defaultCode, $params)) {
            $code = $data[$params[$defaultCode]];
        } elseif (array_key_exists($alternativetCode, $params)) {
            $code = $data[$params[$alternativetCode]];
            $code = Str::camel($code);
        } else {

        }
        return $code;
    }

    private function getLibelle($name, $params, $data)
    {
//        dd($data,$name,$params);
        $libelle = " ";
        if (array_key_exists($name, $params)) {
            $libelle = $data[$params[$name]];
        }

        return strval($libelle);
    }
}
