<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MatrimonialesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        \DB::table('matrimoniales')->delete();
        \DB::table('matrimoniales')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'libelle' => 'Marier',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            1 =>
                array (
                    'id' => 2,
                    'libelle' => 'Celibataire',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),

        ));



    }
}
