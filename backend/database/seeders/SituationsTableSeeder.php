<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SituationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('situations')->delete();
        
        \DB::table('situations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'En poste',
                'created_at' => '2021-11-11 08:36:36',
                'updated_at' => '2021-11-11 08:36:36',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Retraité',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'Décédé',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'Licencié',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
        ));
        
        
    }
}