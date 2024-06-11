<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SoldablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        \DB::table('soldables')->delete();
        \DB::table('soldables')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'libelle' => 'Oui',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            1 =>
                array (
                    'id' => 2,
                    'libelle' => 'Non',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),

        ));



    }
}
