<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SexesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sexes')->delete();
        
        \DB::table('sexes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Masculin',
                'created_at' => '2021-11-11 08:36:36',
                'updated_at' => '2021-11-11 08:36:36',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Feminin',
                'created_at' => '2021-11-11 08:36:36',
                'updated_at' => '2021-11-11 08:36:36',
            ),
            2 => 
            array (
                'id' => 15,
                'libelle' => 'M',
                'created_at' => '2021-12-13 09:08:35',
                'updated_at' => '2021-12-13 09:08:35',
            ),
            3 => 
            array (
                'id' => 16,
                'libelle' => 'F',
                'created_at' => '2021-12-13 09:08:35',
                'updated_at' => '2021-12-13 09:08:35',
            ),
        ));
        
        
    }
}