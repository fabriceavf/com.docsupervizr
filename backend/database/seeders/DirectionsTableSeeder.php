<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DirectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('directions')->delete();
        
        \DB::table('directions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => '',
                'code' => NULL,
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'groupedirection_id' => NULL,
                'deleted_at' => NULL,
                'identifiants_sadge' => NULL,
                'creat_by' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'logistique',
                'code' => NULL,
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'groupedirection_id' => NULL,
                'deleted_at' => NULL,
                'identifiants_sadge' => NULL,
                'creat_by' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'entrepot',
                'code' => NULL,
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'groupedirection_id' => NULL,
                'deleted_at' => NULL,
                'identifiants_sadge' => NULL,
                'creat_by' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'commercial',
                'code' => NULL,
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'groupedirection_id' => NULL,
                'deleted_at' => NULL,
                'identifiants_sadge' => NULL,
                'creat_by' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => 'adm',
                'code' => NULL,
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'groupedirection_id' => NULL,
                'deleted_at' => NULL,
                'identifiants_sadge' => NULL,
                'creat_by' => NULL,
            ),
        ));
        
        
    }
}