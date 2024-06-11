<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HorairesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('horaires')->delete();

        \DB::table('horaires')->insert(array (
            0 =>
            array (
                'id' => 1,
                'libelle' => '20H-06H',
                'debut' => '20:00:00',
                'fin' => '06:00:00',
                'tolerance' => '0',
                'type' => 'Nuit',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:27',
                'updated_at' => '2023-02-15 13:43:27',
                'tache_id' => 2,
            ),
            1 =>
            array (
                'id' => 2,
                'libelle' => '07H30-17H30',
                'debut' => '07:30:00',
                'fin' => '17:30:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:27',
                'updated_at' => '2023-02-15 13:43:27',
                'tache_id' => 2,
            ),
            2 =>
            array (
                'id' => 3,
                'libelle' => '07H30-15H30',
                'debut' => '07:30:00',
                'fin' => '15:30:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:27',
                'updated_at' => '2023-02-15 13:43:27',
                'tache_id' => 2,
            ),
            3 =>
            array (
                'id' => 4,
                'libelle' => '09H00-17H00',
                'debut' => '09:00:00',
                'fin' => '17:00:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:27',
                'updated_at' => '2023-02-15 13:43:27',
                'tache_id' => 2,
            ),
            4 =>
            array (
                'id' => 5,
                'libelle' => '20H-06H',
                'debut' => '20:00:00',
                'fin' => '06:00:00',
                'tolerance' => '0',
                'type' => 'Nuit',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:27',
                'updated_at' => '2023-02-15 13:43:27',
                'tache_id' => 5,
            ),
            5 =>
            array (
                'id' => 6,
                'libelle' => '07H30-17H30',
                'debut' => '07:30:00',
                'fin' => '17:30:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:28',
                'updated_at' => '2023-02-15 13:43:28',
                'tache_id' => 5,
            ),
            6 =>
            array (
                'id' => 7,
                'libelle' => '07H30-15H30',
                'debut' => '07:30:00',
                'fin' => '15:30:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'extra_attributes' => NULL,
                'created_at' => '2023-02-15 13:43:28',
                'updated_at' => '2023-02-15 13:43:28',
                'tache_id' => 5,
            ),
        ));


    }
}
