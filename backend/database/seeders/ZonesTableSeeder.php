<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('zones')->delete();
        
        \DB::table('zones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'libelle' => 'Zone 2',
                'created_at' => '2021-11-11 09:24:16',
                'updated_at' => '2021-11-11 09:24:16',
                'province_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'libelle' => 'Zone 3',
                'created_at' => '2021-11-12 12:05:38',
                'updated_at' => '2021-11-12 12:05:38',
                'province_id' => 1,
            ),
            2 => 
            array (
                'id' => 143,
                'code' => NULL,
                'libelle' => 'Libreville Zone 3',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            3 => 
            array (
                'id' => 144,
                'code' => NULL,
                'libelle' => 'Franceville Haut Ogooue',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            4 => 
            array (
                'id' => 145,
                'code' => NULL,
                'libelle' => 'Moanda Haut Ogooue',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            5 => 
            array (
                'id' => 146,
                'code' => NULL,
                'libelle' => 'Libreville Libreville',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            6 => 
            array (
                'id' => 147,
                'code' => NULL,
                'libelle' => 'Port-Gentil Mep',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            7 => 
            array (
                'id' => 148,
                'code' => NULL,
                'libelle' => 'Port-Gentil Agence',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            8 => 
            array (
                'id' => 149,
                'code' => NULL,
                'libelle' => 'Port-Gentil Site Assala',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            9 => 
            array (
                'id' => 150,
                'code' => NULL,
                'libelle' => 'Libreville Zone 2',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            10 => 
            array (
                'id' => 151,
                'code' => NULL,
                'libelle' => 'Tchibanga Sites Interieur',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            11 => 
            array (
                'id' => 153,
                'code' => NULL,
                'libelle' => 'Bakoudou Haut Ogooue',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            12 => 
            array (
                'id' => 154,
                'code' => NULL,
                'libelle' => 'Bongoville Haut Ogooue',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
                'province_id' => 1,
            ),
            13 => 
            array (
                'id' => 155,
                'code' => NULL,
                'libelle' => 'Akanda Zone 1',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            14 => 
            array (
                'id' => 156,
                'code' => NULL,
                'libelle' => 'Port-Gentil Rabi',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            15 => 
            array (
                'id' => 157,
                'code' => NULL,
                'libelle' => 'Lambarene Site Interieur',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            16 => 
            array (
                'id' => 158,
                'code' => NULL,
                'libelle' => 'Koulamoutou Ogooue Lolo',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            17 => 
            array (
                'id' => 159,
                'code' => NULL,
                'libelle' => 'Leconi Haut Ogooue',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            18 => 
            array (
                'id' => 160,
                'code' => NULL,
                'libelle' => 'Owendo Zone 3',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            19 => 
            array (
                'id' => 161,
                'code' => NULL,
                'libelle' => 'Gamba Rabi',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            20 => 
            array (
                'id' => 162,
                'code' => NULL,
                'libelle' => 'Port-Gentil Site',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            21 => 
            array (
                'id' => 163,
                'code' => NULL,
                'libelle' => 'Mouila Site Interieur',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            22 => 
            array (
                'id' => 164,
                'code' => NULL,
                'libelle' => 'Ntoum Zone 2',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
                'province_id' => 1,
            ),
            23 => 
            array (
                'id' => 165,
                'code' => NULL,
                'libelle' => 'Akanda Gi Stat',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
                'province_id' => 1,
            ),
            24 => 
            array (
                'id' => 166,
                'code' => NULL,
                'libelle' => 'Ntoum Ntoum',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
                'province_id' => 1,
            ),
            25 => 
            array (
                'id' => 167,
                'code' => NULL,
                'libelle' => 'Ntoum Sites Interieur',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
                'province_id' => 1,
            ),
            26 => 
            array (
                'id' => 168,
                'code' => NULL,
                'libelle' => 'Akanda Zone 2',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
                'province_id' => 1,
            ),
            27 => 
            array (
                'id' => 169,
                'code' => NULL,
                'libelle' => 'Ndjole Site Interieur',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
                'province_id' => 1,
            ),
            28 => 
            array (
                'id' => 170,
                'code' => NULL,
                'libelle' => 'Port-Gentil Gamba',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
                'province_id' => 1,
            ),
            29 => 
            array (
                'id' => 171,
                'code' => NULL,
                'libelle' => 'Bakoumba Haut Ogooue',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
                'province_id' => 1,
            ),
            30 => 
            array (
                'id' => 172,
                'code' => NULL,
                'libelle' => 'Tchibanga Site Interieur',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
                'province_id' => 1,
            ),
            31 => 
            array (
                'id' => 173,
                'code' => NULL,
                'libelle' => 'Port-Gentil Site Rabi',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
                'province_id' => 1,
            ),
            32 => 
            array (
                'id' => 174,
                'code' => NULL,
                'libelle' => 'Port-Gentil Site Interieur',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
                'province_id' => 1,
            ),
            33 => 
            array (
                'id' => 175,
                'code' => NULL,
                'libelle' => 'Awoun Awoun',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
                'province_id' => 1,
            ),
            34 => 
            array (
                'id' => 176,
                'code' => NULL,
                'libelle' => 'Port-Gentil Awoun',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
                'province_id' => 1,
            ),
            35 => 
            array (
                'id' => 177,
                'code' => NULL,
                'libelle' => 'Ntoum Site Interieur',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
                'province_id' => 1,
            ),
            36 => 
            array (
                'id' => 178,
                'code' => NULL,
                'libelle' => 'Port-Gentil Agence Pog',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
                'province_id' => 1,
            ),
            37 => 
            array (
                'id' => 179,
                'code' => NULL,
                'libelle' => 'Lastoursville Ogooue Lolo',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
                'province_id' => 1,
            ),
            38 => 
            array (
                'id' => 180,
                'code' => NULL,
                'libelle' => 'Libreville Site Interieur',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
                'province_id' => 1,
            ),
            39 => 
            array (
                'id' => 181,
                'code' => NULL,
                'libelle' => 'Ntoum Okolassi',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
                'province_id' => 1,
            ),
            40 => 
            array (
                'id' => 182,
                'code' => NULL,
                'libelle' => 'Gamba Gamba',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
                'province_id' => 1,
            ),
            41 => 
            array (
                'id' => 183,
                'code' => NULL,
                'libelle' => 'Awoun Zone 3',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
                'province_id' => 1,
            ),
            42 => 
            array (
                'id' => 184,
                'code' => NULL,
                'libelle' => 'Owendo Zone 2',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
                'province_id' => 1,
            ),
            43 => 
            array (
                'id' => 185,
                'code' => NULL,
                'libelle' => 'Toucan Toucan',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
                'province_id' => 1,
            ),
            44 => 
            array (
                'id' => 186,
                'code' => NULL,
                'libelle' => 'Lambarene Sites Interieur',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
                'province_id' => 1,
            ),
            45 => 
            array (
                'id' => 187,
                'code' => NULL,
                'libelle' => 'Port-Gentil Site Csp',
                'created_at' => '2021-12-12 19:45:01',
                'updated_at' => '2021-12-12 19:45:01',
                'province_id' => 1,
            ),
            46 => 
            array (
                'id' => 188,
                'code' => '01',
                'libelle' => 'Port-Gentil',
                'created_at' => '2021-12-15 12:19:55',
                'updated_at' => '2021-12-15 12:19:55',
                'province_id' => 8,
            ),
            47 => 
            array (
                'id' => 189,
                'code' => NULL,
                'libelle' => 'Toucan Toucan',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            48 => 
            array (
                'id' => 190,
                'code' => NULL,
                'libelle' => 'Oyem Woleu Ntem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            49 => 
            array (
                'id' => 191,
                'code' => NULL,
                'libelle' => 'Oyem Oyem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            50 => 
            array (
                'id' => 192,
                'code' => NULL,
                'libelle' => 'Mitzic Woleu-Ntem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            51 => 
            array (
                'id' => 193,
                'code' => NULL,
                'libelle' => 'Zomoko - Kibg Woleu-Ntem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            52 => 
            array (
                'id' => 194,
                'code' => NULL,
                'libelle' => 'Mbomaho - Lalara Ogooue - Ivindo',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            53 => 
            array (
                'id' => 195,
                'code' => NULL,
                'libelle' => 'Oyem Woleu-Ntem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            54 => 
            array (
                'id' => 196,
                'code' => NULL,
                'libelle' => 'Zomoko - Mtz Woleu-Ntem',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            55 => 
            array (
                'id' => 197,
                'code' => NULL,
                'libelle' => 'Libreville Zone 2',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
                'province_id' => 9,
            ),
            56 => 
            array (
                'id' => 198,
                'code' => '003',
                'libelle' => 'Libreville Zone 3',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2022-01-05 09:12:42',
                'province_id' => 1,
            ),
            57 => 
            array (
                'id' => 199,
                'code' => '004',
                'libelle' => 'Port-Gentil',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-28 15:34:45',
                'province_id' => 8,
            ),
            58 => 
            array (
                'id' => 200,
                'code' => '008',
                'libelle' => 'Moanda COMILOG',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2022-01-08 22:00:01',
                'province_id' => 2,
            ),
            59 => 
            array (
                'id' => 201,
                'code' => '001',
                'libelle' => 'Libreville Zone 1',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2022-01-05 09:11:26',
                'province_id' => 1,
            ),
            60 => 
            array (
                'id' => 202,
                'code' => '002',
                'libelle' => 'Libreville Zone 2',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2022-01-05 09:11:57',
                'province_id' => 1,
            ),
            61 => 
            array (
                'id' => 203,
                'code' => '009',
                'libelle' => 'Moanda site extérieur',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2022-01-05 09:15:55',
                'province_id' => 2,
            ),
            62 => 
            array (
                'id' => 204,
                'code' => NULL,
                'libelle' => 'Okolassi Estuaire',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
                'province_id' => 9,
            ),
            63 => 
            array (
                'id' => 205,
                'code' => NULL,
                'libelle' => 'Ntoum Estuaire',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
                'province_id' => 9,
            ),
            64 => 
            array (
                'id' => 206,
                'code' => NULL,
                'libelle' => 'Nkoltang Estuaire',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
                'province_id' => 9,
            ),
            65 => 
            array (
                'id' => 207,
                'code' => '005',
                'libelle' => 'Site intérieur G1',
                'created_at' => '2021-12-27 13:50:24',
                'updated_at' => '2022-01-05 09:13:11',
                'province_id' => 1,
            ),
            66 => 
            array (
                'id' => 208,
                'code' => '007',
                'libelle' => 'Site intérieur G9',
                'created_at' => '2021-12-28 15:08:09',
                'updated_at' => '2022-01-05 09:14:04',
                'province_id' => 9,
            ),
            67 => 
            array (
                'id' => 209,
                'code' => '006',
                'libelle' => 'Site intérieur G4',
                'created_at' => '2021-12-31 11:08:21',
                'updated_at' => '2022-01-05 09:13:37',
                'province_id' => 4,
            ),
            68 => 
            array (
                'id' => 212,
                'code' => '201',
                'libelle' => 'Chancelerie',
                'created_at' => '2022-01-12 10:56:01',
                'updated_at' => '2022-01-12 10:56:01',
                'province_id' => 1,
            ),
            69 => 
            array (
                'id' => 233,
                'code' => '114',
                'libelle' => 'BUREAU',
                'created_at' => '2022-01-14 07:39:24',
                'updated_at' => '2022-01-14 07:39:24',
                'province_id' => 1,
            ),
            70 => 
            array (
                'id' => 242,
                'code' => NULL,
                'libelle' => 'vide',
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 0,
            ),
            71 => 
            array (
                'id' => 243,
                'code' => NULL,
                'libelle' => 'Toucan',
                'created_at' => '2022-05-11 16:16:48',
                'updated_at' => '2022-05-11 16:16:48',
                'province_id' => 1,
            ),
            72 => 
            array (
                'id' => 244,
                'code' => NULL,
                'libelle' => 'Woleu Ntem',
                'created_at' => '2022-05-11 16:16:48',
                'updated_at' => '2022-05-11 16:16:48',
                'province_id' => 1,
            ),
            73 => 
            array (
                'id' => 245,
                'code' => NULL,
                'libelle' => 'Oyem',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
                'province_id' => 1,
            ),
            74 => 
            array (
                'id' => 246,
                'code' => NULL,
                'libelle' => 'Woleu-Ntem',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
                'province_id' => 1,
            ),
            75 => 
            array (
                'id' => 247,
                'code' => NULL,
                'libelle' => 'Ogooue - Ivindo',
                'created_at' => '2022-05-11 16:16:52',
                'updated_at' => '2022-05-11 16:16:52',
                'province_id' => 1,
            ),
            76 => 
            array (
                'id' => 248,
                'code' => NULL,
                'libelle' => 'Mep',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
                'province_id' => 1,
            ),
            77 => 
            array (
                'id' => 249,
                'code' => NULL,
                'libelle' => 'Haut Ogooue',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
                'province_id' => 1,
            ),
            78 => 
            array (
                'id' => 250,
                'code' => NULL,
                'libelle' => 'Zone 1',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
                'province_id' => 1,
            ),
            79 => 
            array (
                'id' => 251,
                'code' => NULL,
                'libelle' => 'Moyen - Ogooue',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
                'province_id' => 1,
            ),
            80 => 
            array (
                'id' => 252,
                'code' => NULL,
                'libelle' => 'Estuaire',
                'created_at' => '2022-05-11 16:16:54',
                'updated_at' => '2022-05-11 16:16:54',
                'province_id' => 1,
            ),
            81 => 
            array (
                'id' => 253,
                'code' => NULL,
                'libelle' => 'Libreville',
                'created_at' => '2022-05-11 16:25:39',
                'updated_at' => '2022-05-11 16:25:39',
                'province_id' => 1,
            ),
            82 => 
            array (
                'id' => 254,
                'code' => NULL,
                'libelle' => 'Agence',
                'created_at' => '2022-05-11 16:25:40',
                'updated_at' => '2022-05-11 16:25:40',
                'province_id' => 1,
            ),
            83 => 
            array (
                'id' => 255,
                'code' => NULL,
                'libelle' => 'Site Assala',
                'created_at' => '2022-05-11 16:25:40',
                'updated_at' => '2022-05-11 16:25:40',
                'province_id' => 1,
            ),
            84 => 
            array (
                'id' => 256,
                'code' => NULL,
                'libelle' => 'Sites Interieur',
                'created_at' => '2022-05-11 16:25:40',
                'updated_at' => '2022-05-11 16:25:40',
                'province_id' => 1,
            ),
            85 => 
            array (
                'id' => 257,
                'code' => NULL,
                'libelle' => 'Rabi',
                'created_at' => '2022-05-11 16:25:42',
                'updated_at' => '2022-05-11 16:25:42',
                'province_id' => 1,
            ),
            86 => 
            array (
                'id' => 258,
                'code' => NULL,
                'libelle' => 'Site Interieur',
                'created_at' => '2022-05-11 16:25:43',
                'updated_at' => '2022-05-11 16:25:43',
                'province_id' => 1,
            ),
            87 => 
            array (
                'id' => 259,
                'code' => NULL,
                'libelle' => 'Ogooue Lolo',
                'created_at' => '2022-05-11 16:25:43',
                'updated_at' => '2022-05-11 16:25:43',
                'province_id' => 1,
            ),
            88 => 
            array (
                'id' => 260,
                'code' => NULL,
                'libelle' => 'Site',
                'created_at' => '2022-05-11 16:25:48',
                'updated_at' => '2022-05-11 16:25:48',
                'province_id' => 1,
            ),
            89 => 
            array (
                'id' => 261,
                'code' => NULL,
                'libelle' => 'Ntoum',
                'created_at' => '2022-05-11 16:25:54',
                'updated_at' => '2022-05-11 16:25:54',
                'province_id' => 1,
            ),
            90 => 
            array (
                'id' => 262,
                'code' => NULL,
                'libelle' => 'Gamba',
                'created_at' => '2022-05-11 16:26:14',
                'updated_at' => '2022-05-11 16:26:14',
                'province_id' => 1,
            ),
            91 => 
            array (
                'id' => 263,
                'code' => NULL,
                'libelle' => 'Gi Stat',
                'created_at' => '2022-05-11 16:26:15',
                'updated_at' => '2022-05-11 16:26:15',
                'province_id' => 1,
            ),
            92 => 
            array (
                'id' => 264,
                'code' => NULL,
                'libelle' => 'Site Rabi',
                'created_at' => '2022-05-11 16:26:19',
                'updated_at' => '2022-05-11 16:26:19',
                'province_id' => 1,
            ),
            93 => 
            array (
                'id' => 265,
                'code' => NULL,
                'libelle' => 'Awoun',
                'created_at' => '2022-05-11 16:26:26',
                'updated_at' => '2022-05-11 16:26:26',
                'province_id' => 1,
            ),
            94 => 
            array (
                'id' => 266,
                'code' => NULL,
                'libelle' => 'Agence Pog',
                'created_at' => '2022-05-11 16:26:57',
                'updated_at' => '2022-05-11 16:26:57',
                'province_id' => 1,
            ),
            95 => 
            array (
                'id' => 267,
                'code' => NULL,
                'libelle' => 'Okolassi',
                'created_at' => '2022-05-11 16:27:02',
                'updated_at' => '2022-05-11 16:27:02',
                'province_id' => 1,
            ),
            96 => 
            array (
                'id' => 268,
                'code' => NULL,
                'libelle' => 'Site Csp',
                'created_at' => '2022-05-11 16:27:38',
                'updated_at' => '2022-05-11 16:27:38',
                'province_id' => 1,
            ),
        ));
        
        
    }
}