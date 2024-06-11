<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VillesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('villes')->delete();
        
        \DB::table('villes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Libreville',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Port-Gentil',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'Moanda',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'Oyem',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => 'Mouila',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => 'Franceville',
                'created_at' => '2022-05-04 14:03:46',
                'updated_at' => '2022-05-04 14:03:46',
            ),
            6 => 
            array (
                'id' => 8,
                'libelle' => 'Toucan',
                'created_at' => '2022-05-11 16:16:48',
                'updated_at' => '2022-05-11 16:16:48',
            ),
            7 => 
            array (
                'id' => 9,
                'libelle' => 'Mitzic',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
            ),
            8 => 
            array (
                'id' => 10,
                'libelle' => 'Zomoko - Kibg',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
            ),
            9 => 
            array (
                'id' => 11,
                'libelle' => 'Mbomaho - Lalara',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
            ),
            10 => 
            array (
                'id' => 12,
                'libelle' => 'Zomoko - Mtz',
                'created_at' => '2022-05-11 16:16:53',
                'updated_at' => '2022-05-11 16:16:53',
            ),
            11 => 
            array (
                'id' => 13,
                'libelle' => 'Akanda',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
            ),
            12 => 
            array (
                'id' => 14,
                'libelle' => 'Ndjole',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
            ),
            13 => 
            array (
                'id' => 15,
                'libelle' => 'Okolassi',
                'created_at' => '2022-05-11 16:16:55',
                'updated_at' => '2022-05-11 16:16:55',
            ),
            14 => 
            array (
                'id' => 16,
                'libelle' => 'Ntoum',
                'created_at' => '2022-05-11 16:16:55',
                'updated_at' => '2022-05-11 16:16:55',
            ),
            15 => 
            array (
                'id' => 17,
                'libelle' => 'Nkoltang',
                'created_at' => '2022-05-11 16:16:55',
                'updated_at' => '2022-05-11 16:16:55',
            ),
            16 => 
            array (
                'id' => 18,
                'libelle' => 'Tchibanga',
                'created_at' => '2022-05-11 16:25:40',
                'updated_at' => '2022-05-11 16:25:40',
            ),
            17 => 
            array (
                'id' => 19,
                'libelle' => 'Bakoudou',
                'created_at' => '2022-05-11 16:25:41',
                'updated_at' => '2022-05-11 16:25:41',
            ),
            18 => 
            array (
                'id' => 20,
                'libelle' => 'Bongoville',
                'created_at' => '2022-05-11 16:25:42',
                'updated_at' => '2022-05-11 16:25:42',
            ),
            19 => 
            array (
                'id' => 21,
                'libelle' => 'Lambarene',
                'created_at' => '2022-05-11 16:25:43',
                'updated_at' => '2022-05-11 16:25:43',
            ),
            20 => 
            array (
                'id' => 22,
                'libelle' => 'Koulamoutou',
                'created_at' => '2022-05-11 16:25:43',
                'updated_at' => '2022-05-11 16:25:43',
            ),
            21 => 
            array (
                'id' => 23,
                'libelle' => 'Leconi',
                'created_at' => '2022-05-11 16:25:44',
                'updated_at' => '2022-05-11 16:25:44',
            ),
            22 => 
            array (
                'id' => 24,
                'libelle' => 'Owendo',
                'created_at' => '2022-05-11 16:25:45',
                'updated_at' => '2022-05-11 16:25:45',
            ),
            23 => 
            array (
                'id' => 25,
                'libelle' => 'Gamba',
                'created_at' => '2022-05-11 16:25:48',
                'updated_at' => '2022-05-11 16:25:48',
            ),
            24 => 
            array (
                'id' => 26,
                'libelle' => 'Bakoumba',
                'created_at' => '2022-05-11 16:26:15',
                'updated_at' => '2022-05-11 16:26:15',
            ),
            25 => 
            array (
                'id' => 27,
                'libelle' => 'Awoun',
                'created_at' => '2022-05-11 16:26:26',
                'updated_at' => '2022-05-11 16:26:26',
            ),
            26 => 
            array (
                'id' => 28,
                'libelle' => 'Lastoursville',
                'created_at' => '2022-05-11 16:26:58',
                'updated_at' => '2022-05-11 16:26:58',
            ),
        ));
        
        
    }
}