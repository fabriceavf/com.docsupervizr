<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EchelonsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('echelons')->delete();
        
        \DB::table('echelons')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => '1',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => '2',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => '3',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => '4',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => '5',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => '6',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            6 => 
            array (
                'id' => 7,
                'libelle' => '7',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            7 => 
            array (
                'id' => 8,
                'libelle' => '8',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            8 => 
            array (
                'id' => 9,
                'libelle' => '9',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            9 => 
            array (
                'id' => 10,
                'libelle' => '10',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            10 => 
            array (
                'id' => 41,
                'libelle' => 'CS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            11 => 
            array (
                'id' => 42,
                'libelle' => 'D1',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            12 => 
            array (
                'id' => 43,
                'libelle' => '0',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            13 => 
            array (
                'id' => 44,
                'libelle' => 'C',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            14 => 
            array (
                'id' => 45,
                'libelle' => 'D2',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            15 => 
            array (
                'id' => 46,
                'libelle' => 'I',
                'created_at' => '2021-12-12 19:45:01',
                'updated_at' => '2021-12-12 19:45:01',
            ),
        ));
        
        
    }
}