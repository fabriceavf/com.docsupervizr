<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents')->delete();
        
        \DB::table('documents')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'Sociervices',
                'rubrique' => '1',
                'fichier' => 'documents/ogandagapierre_3702.pdf',
                'agent_id' => 3702,
                'created_at' => '2021-11-17 13:45:16',
                'updated_at' => '2021-11-17 13:45:16',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'photo',
                'rubrique' => 'Statut',
                'fichier' => 'documents/ondo_nnanglionel_17277FSd7S.jpg',
                'agent_id' => 17277,
                'created_at' => '2022-05-20 08:57:52',
                'updated_at' => '2022-05-20 08:57:52',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'photo',
                'rubrique' => 'Statut',
                'fichier' => 'documents/rhatoundat_perinybharett_junior_17300uRmdK.jpg',
                'agent_id' => 17300,
                'created_at' => '2022-05-31 09:55:35',
                'updated_at' => '2022-05-31 09:55:35',
            ),
            3 => 
            array (
                'id' => 5,
                'nom' => 'photo',
                'rubrique' => 'Statut',
                'fichier' => 'documents/nze_mbayannick_landry_17305tcedB.jpg',
                'agent_id' => 17305,
                'created_at' => '2022-06-03 10:36:54',
                'updated_at' => '2022-06-03 10:36:54',
            ),
            4 => 
            array (
                'id' => 6,
                'nom' => 'photo',
                'rubrique' => 'Statut',
                'fichier' => 'documents/mbeng_oyonodoris_17275ZwHt1.jpg',
                'agent_id' => 17275,
                'created_at' => '2022-06-13 14:18:01',
                'updated_at' => '2022-06-13 14:18:01',
            ),
            5 => 
            array (
                'id' => 7,
                'nom' => 'PHOTO',
                'rubrique' => 'Statut',
                'fichier' => 'documents/mendemanarcisse_171432tqNy.jpg',
                'agent_id' => 17143,
                'created_at' => '2022-08-25 09:20:38',
                'updated_at' => '2022-08-25 09:20:38',
            ),
            6 => 
            array (
                'id' => 9,
                'nom' => 'PHOTO',
                'rubrique' => 'Statut',
                'fichier' => 'documents/mendemanarcisse_17143LGfnD.jpg',
                'agent_id' => 17143,
                'created_at' => '2022-08-25 09:25:10',
                'updated_at' => '2022-08-25 09:25:10',
            ),
        ));
        
        
    }
}