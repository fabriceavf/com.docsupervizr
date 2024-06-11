<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SituationMatrimonialesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('situation_matrimoniales')->delete();
        
        \DB::table('situation_matrimoniales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Marié',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Célibataire',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'En couple',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'Autre',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => 'Marié',
                'created_at' => '2021-11-11 15:07:10',
                'updated_at' => '2021-11-11 15:07:10',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => 'Célibataire',
                'created_at' => '2021-11-11 15:07:10',
                'updated_at' => '2021-11-11 15:07:10',
            ),
            6 => 
            array (
                'id' => 7,
                'libelle' => 'En couple',
                'created_at' => '2021-11-11 15:07:10',
                'updated_at' => '2021-11-11 15:07:10',
            ),
            7 => 
            array (
                'id' => 8,
                'libelle' => 'Autre',
                'created_at' => '2021-11-11 15:07:10',
                'updated_at' => '2021-11-11 15:07:10',
            ),
            8 => 
            array (
                'id' => 17,
                'libelle' => 'Concubinage',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            9 => 
            array (
                'id' => 18,
                'libelle' => 'Divorce',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
        ));
        
        
    }
}