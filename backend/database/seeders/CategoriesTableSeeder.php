<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 51,
                'libelle' => '  C',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            1 => 
            array (
                'id' => 52,
                'libelle' => 'HC',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            2 => 
            array (
                'id' => 53,
                'libelle' => 'AE',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            3 => 
            array (
                'id' => 54,
                'libelle' => 'AM',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            4 => 
            array (
                'id' => 56,
                'libelle' => 'CD',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            5 => 
            array (
                'id' => 58,
                'libelle' => 'E',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            6 => 
            array (
                'id' => 59,
                'libelle' => 'CADRE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            7 => 
            array (
                'id' => 60,
                'libelle' => 'D',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            8 => 
            array (
                'id' => 61,
                'libelle' => 'CM',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
        ));
        
        
    }
}