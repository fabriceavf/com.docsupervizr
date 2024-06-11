<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DroitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('droits')->delete();
        
        \DB::table('droits')->insert(array (
            0 => 
            array (
                'id' => 8,
                'libelle' => 'CreerEnrolement',
                'description' => 'Le droit sur la création d\'un nouvel agent',
                'created_at' => '2021-11-12 11:17:40',
                'updated_at' => '2021-11-12 11:17:40',
            ),
            1 => 
            array (
                'id' => 9,
                'libelle' => 'ModifierEnrolement',
                'description' => 'Le droit sur la modification du dossier d\'un agent',
                'created_at' => '2021-11-12 11:17:40',
                'updated_at' => '2021-11-12 11:17:40',
            ),
            2 => 
            array (
                'id' => 10,
                'libelle' => 'ValiderEnrolement',
                'description' => 'Le droit sur la validation de l\'enrolement d\'un nouvel agent',
                'created_at' => '2021-11-12 11:17:40',
                'updated_at' => '2021-11-12 11:17:40',
            ),
            3 => 
            array (
                'id' => 11,
                'libelle' => 'AffecterBadge',
                'description' => 'Le droit sur l\'ajout d\'un badge dans le dossier d\'un agent',
                'created_at' => '2021-11-12 11:17:40',
                'updated_at' => '2021-11-12 11:17:40',
            ),
            4 => 
            array (
                'id' => 12,
                'libelle' => 'SupprimerEnrolement',
                'description' => 'Le droit sur la suppression d\'un agent',
                'created_at' => '2021-11-12 11:17:40',
                'updated_at' => '2021-11-12 11:17:40',
            ),
        ));
        
        
    }
}