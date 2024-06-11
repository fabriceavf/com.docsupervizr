<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypesabscencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('typesabscences')->delete();

        \DB::table('typesabscences')->insert(array (
            0 =>
            array (
                'id' => 1,
                'libelle' => 'Absence Maladie',
                'soldable_id' => 1,
                'variable_id' => 1,
                'nombrejours' => NULL,
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"description":"Absence Maladie"}}',
                'created_at' => '2023-02-20 13:22:02',
                'updated_at' => '2023-02-22 07:57:22',
            ),
            1 =>
            array (
                'id' => 2,
                'libelle' => 'Mariage du travailleur',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '4',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"description":null}}',
                'created_at' => '2023-02-20 15:16:55',
                'updated_at' => '2023-02-22 07:57:37',
            ),
            2 =>
            array (
                'id' => 3,
                'libelle' => 'Mariage de l\'enfant du travailleur',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '2',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"description":null}}',
                'created_at' => '2023-02-20 15:19:23',
                'updated_at' => '2023-02-22 07:58:06',
            ),
            3 =>
            array (
                'id' => 4,
                'libelle' => 'Mariage du frère/soeur du travailleur',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '1',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"service_id":null}}',
                'created_at' => '2023-02-20 15:19:42',
                'updated_at' => '2023-02-22 07:58:31',
            ),
            4 =>
            array (
                'id' => 5,
                'libelle' => 'Décès famille du travailleur',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '5',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"description":"D\\u00e9c\\u00e8s du conjoint, p\\u00e8re, m\\u00e8re et de l\'enfant du travailleur"}}',
                'created_at' => '2023-02-22 07:59:37',
                'updated_at' => '2023-02-22 08:00:13',
            ),
            5 =>
            array (
                'id' => 6,
                'libelle' => 'Décès frère/soeur du travailleur',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '2',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"service_id":null}}',
                'created_at' => '2023-02-22 08:00:06',
                'updated_at' => '2023-02-22 08:00:06',
            ),
            6 =>
            array (
                'id' => 7,
                'libelle' => 'Décès du beau-pète / belle-mère',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '2',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"service_id":null}}',
                'created_at' => '2023-02-22 08:00:55',
                'updated_at' => '2023-02-22 08:00:55',
            ),
            7 =>
            array (
                'id' => 8,
                'libelle' => 'Naissance enfant',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '3',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"service_id":null}}',
                'created_at' => '2023-02-22 08:01:13',
                'updated_at' => '2023-02-22 08:01:13',
            ),
            8 =>
            array (
                'id' => 9,
                'libelle' => 'Cérémonie religieuse',
                'soldable_id' => 1,
                'variable_id' => 2,
                'nombrejours' => '1',
                // 'etats' => NULL,
                'extra_attributes' => '{"extra-data":{"code":null,"service_id":null}}',
                'created_at' => '2023-02-22 08:01:30',
                'updated_at' => '2023-02-22 08:01:30',
            ),
        ));


    }
}
