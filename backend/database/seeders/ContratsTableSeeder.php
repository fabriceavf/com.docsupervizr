<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContratsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contrats')->delete();
        
        \DB::table('contrats')->insert(array (
            0 => 
            array (
                'id' => 15,
                'libelle' => 'CDI',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            1 => 
            array (
                'id' => 16,
                'libelle' => 'CDD',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
        ));
        
        
    }
}