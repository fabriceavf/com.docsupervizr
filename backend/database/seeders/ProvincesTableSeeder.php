<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('provinces')->delete();
        
        \DB::table('provinces')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Estuaire',
                'created_at' => '2021-11-11 08:36:38',
                'updated_at' => '2021-11-11 08:36:38',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Haut-Ogooué',
                'created_at' => '2021-11-11 08:36:38',
                'updated_at' => '2021-11-11 08:36:38',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'Moyen-Ogooué',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'Ngounié',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => 'Nyanga',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => 'Ogooué-Ivindo',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            6 => 
            array (
                'id' => 7,
                'libelle' => 'Ogooué-Lolo',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            7 => 
            array (
                'id' => 8,
                'libelle' => 'Ogooué-Maritime',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
            8 => 
            array (
                'id' => 9,
                'libelle' => 'Woleu-Ntem',
                'created_at' => '2021-11-11 08:36:39',
                'updated_at' => '2021-11-11 08:36:39',
            ),
        ));
        
        
    }
}