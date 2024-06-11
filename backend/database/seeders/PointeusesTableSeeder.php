<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PointeusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('pointeuses')->delete();

        \DB::table('pointeuses')->insert(array (
            0 =>
            array (
                'id' => 1,
                'libelle' => 'NC-206',
                'recupere_id'=>1,
                'created_at' => '2021-12-06 22:28:50',
                'updated_at' => '2021-12-06 22:28:50',
            ),
            1 =>
            array (
                'id' => 2,
                'libelle' => 'NC-210',
                'recupere_id'=>1,
                'created_at' => '2021-12-06 22:30:41',
                'updated_at' => '2021-12-06 22:30:41',
            ),
            2 =>
            array (
                'id' => 3,
                'libelle' => 'NC-209',
                'recupere_id'=>1,
                'created_at' => '2021-12-06 22:30:42',
                'updated_at' => '2021-12-06 22:30:42',
            ),
            3 =>
            array (
                'id' => 4,
                'libelle' => 'NC-205',
                'recupere_id'=>1,
                'created_at' => '2021-12-06 22:30:42',
                'updated_at' => '2021-12-06 22:30:42',
            ),
        ));
        \DB::table('recuperes')->delete();

        \DB::table('recuperes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'libelle' => 'Oui',
                'created_at' => '2021-12-06 22:28:50',
                'updated_at' => '2021-12-06 22:28:50',
            ),
            1 =>
            array (
                'id' => 2,
                'libelle' => 'Non',
                'created_at' => '2021-12-06 22:30:41',
                'updated_at' => '2021-12-06 22:30:41',
            ),

        ));


    }
}
