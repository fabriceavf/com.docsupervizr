<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActifsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        \DB::table('actifs')->delete();
        \DB::table('actifs')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'libelle' => 'Non',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            1 =>
                array (
                    'id' => 2,
                    'libelle' => 'Oui',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),

        ));



    }
}
