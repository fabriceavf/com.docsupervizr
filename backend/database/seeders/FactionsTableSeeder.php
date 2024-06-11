<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('factions')->delete();
        
        \DB::table('factions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Nuit',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Jour',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            2 => 
            array (
                'id' => 15,
                'libelle' => 'Jour/Nuit',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
        ));
        
        
    }
}