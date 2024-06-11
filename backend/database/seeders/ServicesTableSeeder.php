<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('services')->delete();
        
        \DB::table('services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'RH',
                'libelle' => 'Ressources Humaines',
                'extra_attributes' => NULL,
                'created_at' => '2023-01-04 10:51:55',
                'updated_at' => '2023-01-04 10:51:55',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'Compta',
                'libelle' => 'Comptabilité',
                'extra_attributes' => NULL,
                'created_at' => '2023-01-04 10:51:55',
                'updated_at' => '2023-01-04 10:51:55',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'Coll',
                'libelle' => 'Collecte',
                'extra_attributes' => NULL,
                'created_at' => '2023-01-04 10:51:55',
                'updated_at' => '2023-01-04 10:51:55',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'Maint',
                'libelle' => 'Maintenance',
                'extra_attributes' => NULL,
                'created_at' => '2023-01-04 10:51:55',
                'updated_at' => '2023-01-04 10:51:55',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'Relation externe',
                'libelle' => 'Relation externe',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'Adm DT',
                'libelle' => 'Adm DT',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'QHSE',
                'libelle' => 'QHSE',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'Logistique',
                'libelle' => 'Logistique',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'Documentation',
                'libelle' => 'Documentation',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'Collecte',
                'libelle' => 'Collecte',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'Maintenance',
                'libelle' => 'Maintenance',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'Tri et Gestion de déchets',
                'libelle' => 'Tri et Gestion de déchets',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'Personnel',
                'libelle' => 'Personnel',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'Décharge',
                'libelle' => 'Décharge',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'Achats',
                'libelle' => 'Achats',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'Fabri Métallu',
                'libelle' => 'Fabri Métallu',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'Comptabilité',
                'libelle' => 'Comptabilité',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'Pont-bascule',
                'libelle' => 'Pont-bascule',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'Travaux',
                'libelle' => 'Travaux',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'Adm DG',
                'libelle' => 'Adm DG',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'Infirmerie',
                'libelle' => 'Infirmerie',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'Informatique',
                'libelle' => 'Informatique',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'Fabrication Métallurgique',
                'libelle' => 'Fabrication Métallurgique',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'Juridique',
                'libelle' => 'Juridique',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'Communication',
                'libelle' => 'Communication',
                'extra_attributes' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}