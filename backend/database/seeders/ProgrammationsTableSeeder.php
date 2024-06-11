<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgrammationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('programmations')->delete();
        
        \DB::table('programmations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'semaine' => '2022-W46',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:59',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 2,
            ),
            1 => 
            array (
                'id' => 2,
                'semaine' => '2022-W45',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:00',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            2 => 
            array (
                'id' => 3,
                'semaine' => '2022-W46',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:12',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            3 => 
            array (
                'id' => 4,
                'semaine' => '2022-W47',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:17',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            4 => 
            array (
                'id' => 5,
                'semaine' => '2022-W48',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:20',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            5 => 
            array (
                'id' => 6,
                'semaine' => '2022-W49',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:24',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            6 => 
            array (
                'id' => 7,
                'semaine' => '2022-W50',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:27',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            7 => 
            array (
                'id' => 8,
                'semaine' => '2022-W51',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:30',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            8 => 
            array (
                'id' => 9,
                'semaine' => '2022-W52',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:33',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            9 => 
            array (
                'id' => 10,
                'semaine' => '2023-W01',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:37',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            10 => 
            array (
                'id' => 11,
                'semaine' => '2023-W02',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:39',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            11 => 
            array (
                'id' => 12,
                'semaine' => '2023-W03',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:44',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            12 => 
            array (
                'id' => 13,
                'semaine' => '2023-W04',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:47',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            13 => 
            array (
                'id' => 14,
                'semaine' => '2023-W05',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:49',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            14 => 
            array (
                'id' => 15,
                'semaine' => '2023-W06',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:53',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
            15 => 
            array (
                'id' => 16,
                'semaine' => '2023-W07',
                'superviseur' => '0929 OKOSSI OMBINDA Wilfried Fiacre',
                'statut' => 'Terminer',
                'actif' => 0,
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:44:56',
                'updated_at' => '2023-02-15 13:47:01',
                'tache_id' => 5,
            ),
        ));
        
        
    }
}