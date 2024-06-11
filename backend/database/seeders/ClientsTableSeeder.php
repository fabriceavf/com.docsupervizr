<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clients')->delete();
        
        \DB::table('clients')->insert(array (
            0 => 
            array (
                'id' => 909,
                'abreviation' => NULL,
                'nom' => 'SGS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            1 => 
            array (
                'id' => 910,
                'abreviation' => NULL,
                'nom' => 'COMILOG',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            2 => 
            array (
                'id' => 911,
                'abreviation' => 'TOTAL GABON',
                'nom' => 'TOTAL GABON',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-15 14:03:14',
            ),
            3 => 
            array (
                'id' => 912,
                'abreviation' => NULL,
                'nom' => 'SCHLUMBERGER',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            4 => 
            array (
                'id' => 913,
                'abreviation' => NULL,
                'nom' => 'PIZZOLUB',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            5 => 
            array (
                'id' => 914,
                'abreviation' => NULL,
                'nom' => 'SIGALLI',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            6 => 
            array (
                'id' => 915,
                'abreviation' => NULL,
                'nom' => 'ASSALA ENERGY',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            7 => 
            array (
                'id' => 916,
                'abreviation' => NULL,
                'nom' => 'BOLLORE',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            8 => 
            array (
                'id' => 917,
                'abreviation' => NULL,
                'nom' => 'BGFI BANK',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            9 => 
            array (
                'id' => 918,
                'abreviation' => NULL,
                'nom' => 'PMUG',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            10 => 
            array (
                'id' => 919,
                'abreviation' => NULL,
                'nom' => 'CNSS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            11 => 
            array (
                'id' => 920,
                'abreviation' => NULL,
                'nom' => 'CECA GADIS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            12 => 
            array (
                'id' => 921,
                'abreviation' => NULL,
                'nom' => 'BICIG',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            13 => 
            array (
                'id' => 922,
                'abreviation' => NULL,
                'nom' => 'GOC',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            14 => 
            array (
                'id' => 923,
                'abreviation' => NULL,
                'nom' => 'SEEG',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            15 => 
            array (
                'id' => 924,
                'abreviation' => NULL,
                'nom' => 'OCT',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            16 => 
            array (
                'id' => 925,
                'abreviation' => NULL,
                'nom' => 'HOTEL POUBARA',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            17 => 
            array (
                'id' => 926,
                'abreviation' => NULL,
                'nom' => 'AXA GABON',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            18 => 
            array (
                'id' => 927,
                'abreviation' => NULL,
                'nom' => 'CNAMGS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            19 => 
            array (
                'id' => 928,
                'abreviation' => NULL,
                'nom' => 'POOL AÉROPORTURAIRE',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            20 => 
            array (
                'id' => 929,
                'abreviation' => NULL,
                'nom' => 'REG',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            21 => 
            array (
                'id' => 930,
                'abreviation' => NULL,
                'nom' => 'PCA SGS',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            22 => 
            array (
                'id' => 931,
                'abreviation' => NULL,
                'nom' => 'BEAC',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            23 => 
            array (
                'id' => 932,
                'abreviation' => NULL,
                'nom' => 'HOTEL HELICONIA',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            24 => 
            array (
                'id' => 933,
                'abreviation' => NULL,
                'nom' => 'BGFI HOLDING',
                'created_at' => '2021-12-12 19:44:47',
                'updated_at' => '2021-12-12 19:44:47',
            ),
            25 => 
            array (
                'id' => 934,
                'abreviation' => NULL,
                'nom' => 'M. LEE WHITE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            26 => 
            array (
                'id' => 935,
                'abreviation' => NULL,
                'nom' => 'DIRECTION REGIONALE DES IMPOTS',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            27 => 
            array (
                'id' => 936,
                'abreviation' => NULL,
                'nom' => 'MINISTERE DE L\'ECONOMIE ET DES FINANCES',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            28 => 
            array (
                'id' => 937,
                'abreviation' => NULL,
                'nom' => 'CEMA GABON',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            29 => 
            array (
                'id' => 938,
                'abreviation' => NULL,
                'nom' => 'EGAI',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            30 => 
            array (
                'id' => 939,
                'abreviation' => NULL,
                'nom' => 'ECOBANK',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            31 => 
            array (
                'id' => 940,
                'abreviation' => NULL,
                'nom' => 'CFAO',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            32 => 
            array (
                'id' => 941,
                'abreviation' => NULL,
                'nom' => 'EFG',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            33 => 
            array (
                'id' => 942,
                'abreviation' => NULL,
                'nom' => 'GABON TELECOM',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            34 => 
            array (
                'id' => 943,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DE RUSSIE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            35 => 
            array (
                'id' => 944,
                'abreviation' => NULL,
                'nom' => 'SOBOLECO',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            36 => 
            array (
                'id' => 945,
                'abreviation' => NULL,
                'nom' => 'FIDAFRICA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            37 => 
            array (
                'id' => 946,
                'abreviation' => NULL,
                'nom' => 'CAISSE DE DEPOT CONSIGNATION',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            38 => 
            array (
                'id' => 947,
                'abreviation' => NULL,
                'nom' => 'ORABANK',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            39 => 
            array (
                'id' => 948,
                'abreviation' => NULL,
                'nom' => 'STADE DE BONGOVILLE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            40 => 
            array (
                'id' => 949,
                'abreviation' => NULL,
                'nom' => 'OFFICE PHARMACEUTIQUE NATIONAL',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            41 => 
            array (
                'id' => 950,
                'abreviation' => NULL,
                'nom' => 'PERENCO',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            42 => 
            array (
                'id' => 951,
                'abreviation' => NULL,
                'nom' => 'ALIOS FINANCE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            43 => 
            array (
                'id' => 952,
                'abreviation' => NULL,
                'nom' => 'PCA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            44 => 
            array (
                'id' => 953,
                'abreviation' => NULL,
                'nom' => 'UBA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            45 => 
            array (
                'id' => 954,
                'abreviation' => NULL,
                'nom' => 'AVERDA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            46 => 
            array (
                'id' => 955,
                'abreviation' => NULL,
                'nom' => 'SOCIPEG',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            47 => 
            array (
                'id' => 956,
                'abreviation' => NULL,
                'nom' => 'SAN GEL',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            48 => 
            array (
                'id' => 957,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE DES FORESTIERS',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            49 => 
            array (
                'id' => 958,
                'abreviation' => NULL,
                'nom' => 'CONSULAT DE FRANCE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            50 => 
            array (
                'id' => 959,
                'abreviation' => NULL,
                'nom' => 'M. ERNEST MPOUHO',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            51 => 
            array (
                'id' => 960,
                'abreviation' => NULL,
                'nom' => 'OPRAG',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            52 => 
            array (
                'id' => 961,
                'abreviation' => NULL,
                'nom' => 'FUGRO GABON',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            53 => 
            array (
                'id' => 962,
                'abreviation' => NULL,
                'nom' => 'MGV',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            54 => 
            array (
                'id' => 963,
                'abreviation' => NULL,
                'nom' => 'UGB',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            55 => 
            array (
                'id' => 964,
                'abreviation' => NULL,
                'nom' => 'SECRETARIAT GENERAL DU GOUVERNEMENT',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            56 => 
            array (
                'id' => 965,
                'abreviation' => NULL,
                'nom' => 'FRIEDLANDER',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            57 => 
            array (
                'id' => 966,
                'abreviation' => NULL,
                'nom' => 'MAUREL ET PROM',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            58 => 
            array (
                'id' => 967,
                'abreviation' => NULL,
                'nom' => 'LOXIA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            59 => 
            array (
                'id' => 968,
                'abreviation' => NULL,
                'nom' => 'DIRECTION GENERALE DES IMPOTS',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            60 => 
            array (
                'id' => 969,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DE FRANCE',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            61 => 
            array (
                'id' => 970,
                'abreviation' => NULL,
                'nom' => 'EXTERIEUR/HELICONIA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            62 => 
            array (
                'id' => 971,
                'abreviation' => NULL,
                'nom' => 'MONEY GRAM',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            63 => 
            array (
                'id' => 972,
                'abreviation' => NULL,
                'nom' => 'SNAT',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            64 => 
            array (
                'id' => 973,
                'abreviation' => NULL,
                'nom' => 'SOBRAGA',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            65 => 
            array (
                'id' => 974,
                'abreviation' => NULL,
                'nom' => 'DIRECTION PROVINCIALE DES IMPOTS',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            66 => 
            array (
                'id' => 975,
                'abreviation' => NULL,
                'nom' => 'TRACTAFRIC',
                'created_at' => '2021-12-12 19:44:48',
                'updated_at' => '2021-12-12 19:44:48',
            ),
            67 => 
            array (
                'id' => 976,
                'abreviation' => NULL,
                'nom' => 'LOXEA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            68 => 
            array (
                'id' => 977,
                'abreviation' => NULL,
                'nom' => 'TOTAL GRAZANI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            69 => 
            array (
                'id' => 978,
                'abreviation' => NULL,
                'nom' => 'IMPOTS',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            70 => 
            array (
                'id' => 979,
                'abreviation' => NULL,
                'nom' => 'KFC',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            71 => 
            array (
                'id' => 980,
                'abreviation' => NULL,
                'nom' => 'TV+',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            72 => 
            array (
                'id' => 981,
                'abreviation' => NULL,
                'nom' => 'IPG',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            73 => 
            array (
                'id' => 982,
                'abreviation' => NULL,
                'nom' => 'CEEAC',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            74 => 
            array (
                'id' => 983,
                'abreviation' => NULL,
                'nom' => 'TOTAL',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            75 => 
            array (
                'id' => 984,
                'abreviation' => NULL,
                'nom' => 'GAMBA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            76 => 
            array (
                'id' => 985,
                'abreviation' => NULL,
                'nom' => 'FONDATION MADAME LA PRESIDENTE',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            77 => 
            array (
                'id' => 986,
                'abreviation' => NULL,
                'nom' => 'SATRAM',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            78 => 
            array (
                'id' => 987,
                'abreviation' => NULL,
                'nom' => 'MINISTERE TRAVAUX PUBLIQUES',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            79 => 
            array (
                'id' => 988,
                'abreviation' => NULL,
                'nom' => 'CITIBANK',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            80 => 
            array (
                'id' => 989,
                'abreviation' => NULL,
                'nom' => 'CRBC',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            81 => 
            array (
                'id' => 990,
                'abreviation' => NULL,
                'nom' => 'DIRECTION DU PATRIMOINE',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            82 => 
            array (
                'id' => 991,
                'abreviation' => NULL,
                'nom' => 'REGIS DU TABAC',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            83 => 
            array (
                'id' => 992,
                'abreviation' => NULL,
                'nom' => 'M.RAWIRI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            84 => 
            array (
                'id' => 993,
                'abreviation' => NULL,
                'nom' => 'CEM GABON',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            85 => 
            array (
                'id' => 994,
                'abreviation' => NULL,
                'nom' => 'SNI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            86 => 
            array (
                'id' => 995,
                'abreviation' => NULL,
                'nom' => 'MR JOUMAS',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            87 => 
            array (
                'id' => 996,
                'abreviation' => NULL,
                'nom' => 'M. HONORINE DOSSOU NACKI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            88 => 
            array (
                'id' => 997,
                'abreviation' => NULL,
                'nom' => 'MME. DOUSSOU NACKI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            89 => 
            array (
                'id' => 998,
                'abreviation' => NULL,
                'nom' => 'SPDI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            90 => 
            array (
                'id' => 999,
                'abreviation' => NULL,
                'nom' => 'SETEG',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            91 => 
            array (
                'id' => 1000,
                'abreviation' => NULL,
                'nom' => 'MME. NESTA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            92 => 
            array (
                'id' => 1001,
                'abreviation' => NULL,
                'nom' => 'M. MASSASSA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            93 => 
            array (
                'id' => 1002,
                'abreviation' => NULL,
                'nom' => 'MINISTERE DU PETROLE ET MINES',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            94 => 
            array (
                'id' => 1003,
                'abreviation' => NULL,
                'nom' => 'MR. ALEKA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            95 => 
            array (
                'id' => 1004,
                'abreviation' => NULL,
                'nom' => 'AFD',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            96 => 
            array (
                'id' => 1005,
                'abreviation' => NULL,
                'nom' => 'M. BOUMAH',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            97 => 
            array (
                'id' => 1006,
                'abreviation' => NULL,
                'nom' => 'COPS',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            98 => 
            array (
                'id' => 1007,
                'abreviation' => NULL,
                'nom' => 'M. TOMASSINI',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            99 => 
            array (
                'id' => 1008,
                'abreviation' => NULL,
                'nom' => 'DAVUM',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            100 => 
            array (
                'id' => 1009,
                'abreviation' => NULL,
                'nom' => 'MR ALEKA',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            101 => 
            array (
                'id' => 1010,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DU KOWEIT',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            102 => 
            array (
                'id' => 1011,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DE CHINE',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            103 => 
            array (
                'id' => 1012,
                'abreviation' => NULL,
                'nom' => 'DIESEL GABON',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            104 => 
            array (
                'id' => 1013,
                'abreviation' => NULL,
                'nom' => 'NTBNI BUREAU',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            105 => 
            array (
                'id' => 1014,
                'abreviation' => NULL,
                'nom' => 'M. LOURY NDOYE',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            106 => 
            array (
                'id' => 1015,
                'abreviation' => NULL,
                'nom' => 'MINISTÈRE DES IMPÔTS',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            107 => 
            array (
                'id' => 1016,
                'abreviation' => NULL,
                'nom' => 'CCF',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            108 => 
            array (
                'id' => 1017,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DU BRESIL',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            109 => 
            array (
                'id' => 1018,
                'abreviation' => NULL,
                'nom' => 'PRICE WATERHOUSE',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            110 => 
            array (
                'id' => 1019,
                'abreviation' => NULL,
                'nom' => 'M. PACOME BONGO',
                'created_at' => '2021-12-12 19:44:49',
                'updated_at' => '2021-12-12 19:44:49',
            ),
            111 => 
            array (
                'id' => 1020,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DU LIBAN',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            112 => 
            array (
                'id' => 1021,
                'abreviation' => NULL,
                'nom' => 'ENGEN',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            113 => 
            array (
                'id' => 1022,
                'abreviation' => NULL,
                'nom' => 'YAMAHA',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            114 => 
            array (
                'id' => 1023,
                'abreviation' => NULL,
                'nom' => 'CITE SNI ANGONDJET',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            115 => 
            array (
                'id' => 1024,
                'abreviation' => NULL,
                'nom' => 'TBNI',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            116 => 
            array (
                'id' => 1025,
                'abreviation' => NULL,
                'nom' => 'PAYERIE DE FRANCE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            117 => 
            array (
                'id' => 1026,
                'abreviation' => NULL,
                'nom' => 'ARIANE NKOLTANG',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            118 => 
            array (
                'id' => 1027,
                'abreviation' => NULL,
                'nom' => 'GSM',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            119 => 
            array (
                'id' => 1028,
                'abreviation' => NULL,
                'nom' => 'SOGAFRIC',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            120 => 
            array (
                'id' => 1029,
                'abreviation' => NULL,
                'nom' => 'HOTEL ORCHIDEE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            121 => 
            array (
                'id' => 1030,
                'abreviation' => NULL,
                'nom' => 'TURKISH AIRLINES',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            122 => 
            array (
                'id' => 1031,
                'abreviation' => NULL,
                'nom' => 'MICHEL DIRAT',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            123 => 
            array (
                'id' => 1032,
                'abreviation' => NULL,
                'nom' => 'CEDICOM',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            124 => 
            array (
                'id' => 1033,
                'abreviation' => NULL,
                'nom' => 'DOSSOU NAKI',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            125 => 
            array (
                'id' => 1034,
                'abreviation' => NULL,
                'nom' => 'CGTE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            126 => 
            array (
                'id' => 1035,
                'abreviation' => NULL,
                'nom' => 'CGCL',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            127 => 
            array (
                'id' => 1036,
                'abreviation' => NULL,
                'nom' => 'GABON UPSTREM',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            128 => 
            array (
                'id' => 1037,
                'abreviation' => NULL,
                'nom' => 'MR BERRE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            129 => 
            array (
                'id' => 1038,
                'abreviation' => NULL,
                'nom' => 'MR ANDJOUA',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            130 => 
            array (
                'id' => 1039,
                'abreviation' => NULL,
                'nom' => 'EPIGAT',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            131 => 
            array (
                'id' => 1040,
                'abreviation' => NULL,
                'nom' => 'COLAS',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            132 => 
            array (
                'id' => 1041,
                'abreviation' => NULL,
                'nom' => 'OGAR VIE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            133 => 
            array (
                'id' => 1042,
                'abreviation' => NULL,
                'nom' => 'AIR FRANCE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            134 => 
            array (
                'id' => 1043,
                'abreviation' => NULL,
                'nom' => 'SUPERGEL',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            135 => 
            array (
                'id' => 1044,
                'abreviation' => NULL,
                'nom' => 'ETHIOPIAN AIRLINE',
                'created_at' => '2021-12-12 19:44:50',
                'updated_at' => '2021-12-12 19:44:50',
            ),
            136 => 
            array (
                'id' => 1045,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DE COREE DU SUD',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            137 => 
            array (
                'id' => 1046,
                'abreviation' => NULL,
                'nom' => 'ECOLE DES MINES',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            138 => 
            array (
                'id' => 1047,
                'abreviation' => NULL,
                'nom' => 'MR. MBOUROU',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            139 => 
            array (
                'id' => 1048,
                'abreviation' => NULL,
                'nom' => 'IMP CONSEIL',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            140 => 
            array (
                'id' => 1049,
                'abreviation' => NULL,
                'nom' => 'SOCIETE DE PATRIMOINE',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            141 => 
            array (
                'id' => 1050,
                'abreviation' => NULL,
                'nom' => 'EGG',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            142 => 
            array (
                'id' => 1051,
                'abreviation' => NULL,
                'nom' => 'SGCL',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            143 => 
            array (
                'id' => 1052,
                'abreviation' => NULL,
                'nom' => 'GROUPE KABI',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            144 => 
            array (
                'id' => 1053,
                'abreviation' => NULL,
                'nom' => 'C.G.E',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            145 => 
            array (
                'id' => 1054,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE D\'ALGERIE',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            146 => 
            array (
                'id' => 1055,
                'abreviation' => NULL,
                'nom' => 'MR RAWIRI',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            147 => 
            array (
                'id' => 1056,
                'abreviation' => NULL,
                'nom' => 'BARACUDA',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            148 => 
            array (
                'id' => 1057,
                'abreviation' => NULL,
                'nom' => 'MME AMINA',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            149 => 
            array (
                'id' => 1058,
                'abreviation' => NULL,
                'nom' => 'GI FOX',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            150 => 
            array (
                'id' => 1060,
                'abreviation' => NULL,
                'nom' => 'GPM',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            151 => 
            array (
                'id' => 1061,
                'abreviation' => NULL,
                'nom' => 'MR OGOULA',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            152 => 
            array (
                'id' => 1062,
                'abreviation' => NULL,
                'nom' => 'M. OKIKADI',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            153 => 
            array (
                'id' => 1063,
                'abreviation' => NULL,
                'nom' => 'CIM-GABON',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            154 => 
            array (
                'id' => 1064,
                'abreviation' => NULL,
                'nom' => 'CABINET DELOITE',
                'created_at' => '2021-12-12 19:44:51',
                'updated_at' => '2021-12-12 19:44:51',
            ),
            155 => 
            array (
                'id' => 1065,
                'abreviation' => NULL,
                'nom' => 'SOVINGAB',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            156 => 
            array (
                'id' => 1066,
                'abreviation' => NULL,
                'nom' => 'MARIE',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            157 => 
            array (
                'id' => 1067,
                'abreviation' => NULL,
                'nom' => 'MME. MOUSSAVOU ',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            158 => 
            array (
                'id' => 1068,
                'abreviation' => NULL,
                'nom' => 'STUDIO 2020',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            159 => 
            array (
                'id' => 1069,
                'abreviation' => NULL,
                'nom' => 'M. VICE PRESIDENT DU SENAT',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            160 => 
            array (
                'id' => 1070,
                'abreviation' => NULL,
                'nom' => 'M. JOEL OGOUMA',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            161 => 
            array (
                'id' => 1071,
                'abreviation' => NULL,
                'nom' => 'EGCA',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            162 => 
            array (
                'id' => 1072,
                'abreviation' => NULL,
                'nom' => 'SCAN GABON',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            163 => 
            array (
                'id' => 1073,
                'abreviation' => NULL,
                'nom' => 'DGI',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            164 => 
            array (
                'id' => 1074,
                'abreviation' => NULL,
                'nom' => 'MAGNAGNA Christian',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2022-01-05 15:04:16',
            ),
            165 => 
            array (
                'id' => 1075,
                'abreviation' => NULL,
                'nom' => 'SEEG /CNSS',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            166 => 
            array (
                'id' => 1076,
                'abreviation' => NULL,
                'nom' => 'M. ANDJOUA',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            167 => 
            array (
                'id' => 1077,
                'abreviation' => NULL,
                'nom' => 'HOPITAL DE MOUNANA',
                'created_at' => '2021-12-12 19:44:52',
                'updated_at' => '2021-12-12 19:44:52',
            ),
            168 => 
            array (
                'id' => 1078,
                'abreviation' => NULL,
                'nom' => 'HOTEL MBADJA',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            169 => 
            array (
                'id' => 1079,
                'abreviation' => NULL,
                'nom' => 'MOREL ET PROM',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            170 => 
            array (
                'id' => 1080,
                'abreviation' => NULL,
                'nom' => 'TOTAL MARKETING',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            171 => 
            array (
                'id' => 1081,
                'abreviation' => NULL,
                'nom' => 'SINO HYDRO',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            172 => 
            array (
                'id' => 1082,
                'abreviation' => NULL,
                'nom' => 'MATERIAUX REUNIS',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            173 => 
            array (
                'id' => 1083,
                'abreviation' => NULL,
                'nom' => 'HOTEL LITTORAL',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            174 => 
            array (
                'id' => 1084,
                'abreviation' => NULL,
                'nom' => 'SODIPOG',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            175 => 
            array (
                'id' => 1085,
                'abreviation' => NULL,
                'nom' => 'UBIPHARM',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            176 => 
            array (
                'id' => 1086,
                'abreviation' => NULL,
                'nom' => 'PRIX IMPORT',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            177 => 
            array (
                'id' => 1087,
                'abreviation' => NULL,
                'nom' => 'MME OLGA O',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            178 => 
            array (
                'id' => 1088,
                'abreviation' => NULL,
                'nom' => 'IMMEUBLE REGEANOUS',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            179 => 
            array (
                'id' => 1089,
                'abreviation' => NULL,
                'nom' => 'FINATRA',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            180 => 
            array (
                'id' => 1090,
                'abreviation' => NULL,
                'nom' => 'M. MBABIRI GABRIEL',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            181 => 
            array (
                'id' => 1091,
                'abreviation' => NULL,
                'nom' => 'SOBEA',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            182 => 
            array (
                'id' => 1092,
                'abreviation' => NULL,
                'nom' => 'RESTAURANT ICI ET D\'AILLEUR',
                'created_at' => '2021-12-12 19:44:53',
                'updated_at' => '2021-12-12 19:44:53',
            ),
            183 => 
            array (
                'id' => 1093,
                'abreviation' => NULL,
                'nom' => 'ECGA',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            184 => 
            array (
                'id' => 1094,
                'abreviation' => NULL,
                'nom' => 'AMBASSADE DU BURKINA FASO',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            185 => 
            array (
                'id' => 1095,
                'abreviation' => NULL,
                'nom' => 'SCI-YAO',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            186 => 
            array (
                'id' => 1096,
                'abreviation' => NULL,
                'nom' => 'MR MBELE ASSEKO',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            187 => 
            array (
                'id' => 1097,
                'abreviation' => NULL,
                'nom' => 'MR PACOME BONGO',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            188 => 
            array (
                'id' => 1098,
                'abreviation' => NULL,
                'nom' => 'MAERSK',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            189 => 
            array (
                'id' => 1099,
                'abreviation' => NULL,
                'nom' => 'GENERAL ODJA',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            190 => 
            array (
                'id' => 1100,
                'abreviation' => NULL,
                'nom' => 'ONU-SIDA',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            191 => 
            array (
                'id' => 1101,
                'abreviation' => NULL,
                'nom' => 'M. LAWSON',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            192 => 
            array (
                'id' => 1102,
                'abreviation' => NULL,
                'nom' => 'MR YVON BONGO',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            193 => 
            array (
                'id' => 1103,
                'abreviation' => NULL,
                'nom' => 'AWOUN',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            194 => 
            array (
                'id' => 1104,
                'abreviation' => NULL,
                'nom' => 'SENAT MME MILEBOU',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            195 => 
            array (
                'id' => 1105,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE LE PRESIDENT',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            196 => 
            array (
                'id' => 1106,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE ITOLA',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            197 => 
            array (
                'id' => 1107,
                'abreviation' => NULL,
                'nom' => 'M. SEYDOU KANE',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            198 => 
            array (
                'id' => 1108,
                'abreviation' => NULL,
                'nom' => 'HOTEL TROPICANA',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            199 => 
            array (
                'id' => 1109,
                'abreviation' => NULL,
                'nom' => 'MR NDONG',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            200 => 
            array (
                'id' => 1110,
                'abreviation' => NULL,
                'nom' => 'MERIDIEN',
                'created_at' => '2021-12-12 19:44:54',
                'updated_at' => '2021-12-12 19:44:54',
            ),
            201 => 
            array (
                'id' => 1111,
                'abreviation' => NULL,
                'nom' => 'SBM',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            202 => 
            array (
                'id' => 1112,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE CDM',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            203 => 
            array (
                'id' => 1113,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE MODERNE',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            204 => 
            array (
                'id' => 1114,
                'abreviation' => NULL,
                'nom' => 'ANBG',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            205 => 
            array (
                'id' => 1115,
                'abreviation' => NULL,
                'nom' => 'SODEC',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            206 => 
            array (
                'id' => 1116,
                'abreviation' => NULL,
                'nom' => 'MM KEROT',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            207 => 
            array (
                'id' => 1117,
                'abreviation' => NULL,
                'nom' => 'GADICOM WHENZOU',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            208 => 
            array (
                'id' => 1118,
                'abreviation' => NULL,
                'nom' => 'M. SOUAH THOMAS',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            209 => 
            array (
                'id' => 1119,
                'abreviation' => NULL,
                'nom' => 'M.ONOUVIET',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            210 => 
            array (
                'id' => 1120,
                'abreviation' => NULL,
                'nom' => 'M. RAPOTCHOMBO',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            211 => 
            array (
                'id' => 1121,
                'abreviation' => NULL,
                'nom' => 'CHIMIE GABON',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            212 => 
            array (
                'id' => 1122,
                'abreviation' => NULL,
                'nom' => 'M.NZOUBA LEON',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            213 => 
            array (
                'id' => 1123,
                'abreviation' => NULL,
                'nom' => 'FIDAFRICA PRICE',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            214 => 
            array (
                'id' => 1124,
                'abreviation' => NULL,
                'nom' => 'HTG',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            215 => 
            array (
                'id' => 1125,
                'abreviation' => NULL,
                'nom' => 'SGEPP',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            216 => 
            array (
                'id' => 1126,
                'abreviation' => NULL,
                'nom' => 'SOCIGA',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            217 => 
            array (
                'id' => 1127,
                'abreviation' => NULL,
                'nom' => 'MME PATRICIA MANON',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            218 => 
            array (
                'id' => 1128,
                'abreviation' => NULL,
                'nom' => 'EFTB',
                'created_at' => '2021-12-12 19:44:55',
                'updated_at' => '2021-12-12 19:44:55',
            ),
            219 => 
            array (
                'id' => 1129,
                'abreviation' => NULL,
                'nom' => 'MINISTÈRE DE L\'EDUCATION NATIONALE',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            220 => 
            array (
                'id' => 1130,
                'abreviation' => NULL,
                'nom' => 'LEE WHITE',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            221 => 
            array (
                'id' => 1131,
                'abreviation' => NULL,
                'nom' => 'MR ONDZOUGA RUFIN PACOME',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            222 => 
            array (
                'id' => 1132,
                'abreviation' => NULL,
                'nom' => 'FONDATION AMISSA BONGO',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            223 => 
            array (
                'id' => 1133,
                'abreviation' => NULL,
                'nom' => 'ROYAL AIR MAROC',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            224 => 
            array (
                'id' => 1134,
                'abreviation' => NULL,
                'nom' => 'PC GABON USPSTREM',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            225 => 
            array (
                'id' => 1135,
                'abreviation' => NULL,
                'nom' => 'MME. NICOLE ASSELE',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            226 => 
            array (
                'id' => 1136,
                'abreviation' => NULL,
                'nom' => 'INSTITUT DU PETROLE ET DU GAZ',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            227 => 
            array (
                'id' => 1137,
                'abreviation' => NULL,
                'nom' => 'SAGA YARE',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            228 => 
            array (
                'id' => 1138,
                'abreviation' => NULL,
                'nom' => 'SGG',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            229 => 
            array (
                'id' => 1139,
                'abreviation' => NULL,
                'nom' => 'CNI',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            230 => 
            array (
                'id' => 1140,
                'abreviation' => NULL,
                'nom' => 'VILLA DIRECTEUR DES MINES',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            231 => 
            array (
                'id' => 1141,
                'abreviation' => NULL,
                'nom' => 'FIDEL ANDJOUA',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            232 => 
            array (
                'id' => 1142,
                'abreviation' => NULL,
                'nom' => 'SS MO',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            233 => 
            array (
                'id' => 1143,
                'abreviation' => NULL,
                'nom' => 'ANK',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            234 => 
            array (
                'id' => 1144,
                'abreviation' => NULL,
                'nom' => 'SSMO',
                'created_at' => '2021-12-12 19:44:56',
                'updated_at' => '2021-12-12 19:44:56',
            ),
            235 => 
            array (
                'id' => 1145,
                'abreviation' => NULL,
                'nom' => 'SODEPAL',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            236 => 
            array (
                'id' => 1146,
                'abreviation' => NULL,
                'nom' => 'ERNEST MPOUOH',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            237 => 
            array (
                'id' => 1147,
                'abreviation' => NULL,
                'nom' => 'MR IMMONGAULT',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            238 => 
            array (
                'id' => 1148,
                'abreviation' => NULL,
                'nom' => 'SCG-RE',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            239 => 
            array (
                'id' => 1149,
                'abreviation' => NULL,
                'nom' => 'AIR LIQUIDE',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            240 => 
            array (
                'id' => 1150,
                'abreviation' => 'UGB',
                'nom' => 'UNION GABONAISE DE BANQUE',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2023-02-02 09:15:06',
            ),
            241 => 
            array (
                'id' => 1151,
                'abreviation' => NULL,
                'nom' => 'HELI GABON',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            242 => 
            array (
                'id' => 1152,
                'abreviation' => NULL,
                'nom' => 'CSP',
                'created_at' => '2021-12-12 19:44:57',
                'updated_at' => '2021-12-12 19:44:57',
            ),
            243 => 
            array (
                'id' => 1153,
                'abreviation' => NULL,
                'nom' => 'COMUF',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            244 => 
            array (
                'id' => 1154,
                'abreviation' => 'CIRMF',
                'nom' => 'CIRMF',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2023-02-02 09:13:39',
            ),
            245 => 
            array (
                'id' => 1155,
                'abreviation' => NULL,
                'nom' => 'MR NGUEMA BERTHELOT',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            246 => 
            array (
                'id' => 1156,
                'abreviation' => NULL,
                'nom' => 'TELE AFRICA',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            247 => 
            array (
                'id' => 1157,
                'abreviation' => NULL,
                'nom' => 'GABON MINING',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            248 => 
            array (
                'id' => 1158,
                'abreviation' => NULL,
                'nom' => 'SAGA DIFFUSION',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            249 => 
            array (
                'id' => 1159,
                'abreviation' => NULL,
                'nom' => 'MME MBOUSSOU',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            250 => 
            array (
                'id' => 1160,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE AVORBAM',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            251 => 
            array (
                'id' => 1161,
                'abreviation' => NULL,
                'nom' => 'AEA',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            252 => 
            array (
                'id' => 1162,
                'abreviation' => NULL,
                'nom' => 'CRYSTAL',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            253 => 
            array (
                'id' => 1163,
                'abreviation' => NULL,
                'nom' => 'MADAME OLGA O',
                'created_at' => '2021-12-12 19:44:58',
                'updated_at' => '2021-12-12 19:44:58',
            ),
            254 => 
            array (
                'id' => 1164,
                'abreviation' => 'UGB',
                'nom' => 'UBG',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2023-02-02 09:12:22',
            ),
            255 => 
            array (
                'id' => 1165,
                'abreviation' => NULL,
                'nom' => 'SINOPEC',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
            ),
            256 => 
            array (
                'id' => 1167,
                'abreviation' => NULL,
                'nom' => 'REG0',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
            ),
            257 => 
            array (
                'id' => 1168,
                'abreviation' => 'SOCOBA',
                'nom' => 'SOCOBA',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2023-02-02 09:12:51',
            ),
            258 => 
            array (
                'id' => 1169,
                'abreviation' => 'ADL',
                'nom' => 'ADL',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2023-02-02 09:13:13',
            ),
            259 => 
            array (
                'id' => 1170,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE LEON ZNOUBA',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
            ),
            260 => 
            array (
                'id' => 1171,
                'abreviation' => NULL,
                'nom' => 'DELMAS PETROLIUM SERVICES',
                'created_at' => '2021-12-12 19:44:59',
                'updated_at' => '2021-12-12 19:44:59',
            ),
            261 => 
            array (
                'id' => 1172,
                'abreviation' => NULL,
                'nom' => 'DELTA -  PRO',
                'created_at' => '2021-12-12 19:45:00',
                'updated_at' => '2021-12-12 19:45:00',
            ),
            262 => 
            array (
                'id' => 1173,
                'abreviation' => NULL,
                'nom' => 'GAI',
                'created_at' => '2021-12-12 19:45:01',
                'updated_at' => '2021-12-12 19:45:01',
            ),
            263 => 
            array (
                'id' => 1174,
                'abreviation' => NULL,
                'nom' => 'GEOLOGUE',
                'created_at' => '2021-12-12 19:45:01',
                'updated_at' => '2021-12-12 19:45:01',
            ),
            264 => 
            array (
                'id' => 1175,
                'abreviation' => NULL,
                'nom' => 'MERIDIEN/ SATRAM',
                'created_at' => '2021-12-12 19:45:01',
                'updated_at' => '2021-12-12 19:45:01',
            ),
            265 => 
            array (
                'id' => 1176,
                'abreviation' => NULL,
                'nom' => 'SGS REMPLACANT',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2021-12-12 19:45:02',
            ),
            266 => 
            array (
                'id' => 1177,
                'abreviation' => NULL,
                'nom' => 'SGS RONDIER',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2021-12-12 19:45:02',
            ),
            267 => 
            array (
                'id' => 1178,
                'abreviation' => 'GM',
                'nom' => 'GABON MECA',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2023-02-02 09:11:12',
            ),
            268 => 
            array (
                'id' => 1179,
                'abreviation' => NULL,
                'nom' => 'SAGA MANUTENTION',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2021-12-12 19:45:02',
            ),
            269 => 
            array (
                'id' => 1180,
                'abreviation' => NULL,
                'nom' => 'CIMAF',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2021-12-12 19:45:02',
            ),
            270 => 
            array (
                'id' => 1181,
                'abreviation' => NULL,
                'nom' => 'PHARMACIE BOUNDAMA',
                'created_at' => '2021-12-12 19:45:02',
                'updated_at' => '2021-12-12 19:45:02',
            ),
            271 => 
            array (
                'id' => 1182,
                'abreviation' => 'INCONNU',
                'nom' => 'INCONNU',
                'created_at' => '2021-12-14 10:12:59',
                'updated_at' => '2021-12-14 10:12:59',
            ),
            272 => 
            array (
                'id' => 1183,
                'abreviation' => 'ALLIANCE',
                'nom' => 'ALLIANCE',
                'created_at' => '2021-12-15 12:39:06',
                'updated_at' => '2021-12-15 12:39:06',
            ),
            273 => 
            array (
                'id' => 1184,
                'abreviation' => 'DPS',
                'nom' => 'DPS',
                'created_at' => '2021-12-15 12:56:51',
                'updated_at' => '2021-12-15 12:56:51',
            ),
            274 => 
            array (
                'id' => 1185,
                'abreviation' => 'Eglise Universelle',
                'nom' => 'Eglise Universelle',
                'created_at' => '2021-12-15 12:58:56',
                'updated_at' => '2021-12-15 12:58:56',
            ),
            275 => 
            array (
                'id' => 1186,
                'abreviation' => 'PESCHAUD',
                'nom' => 'PESCHAUD',
                'created_at' => '2021-12-15 13:27:15',
                'updated_at' => '2021-12-15 13:27:15',
            ),
            276 => 
            array (
                'id' => 1187,
                'abreviation' => 'SDV',
                'nom' => 'SDV',
                'created_at' => '2021-12-15 13:32:41',
                'updated_at' => '2021-12-15 13:32:41',
            ),
            277 => 
            array (
                'id' => 1188,
                'abreviation' => 'SEEG',
                'nom' => 'SEEG',
                'created_at' => '2021-12-15 13:34:40',
                'updated_at' => '2021-12-15 13:34:40',
            ),
            278 => 
            array (
                'id' => 1189,
                'abreviation' => 'MEF',
                'nom' => 'MINISTERE DE L`ECONOMIE ET DES FINANCES',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2023-02-02 09:10:17',
            ),
            279 => 
            array (
                'id' => 1191,
                'abreviation' => 'BGFI',
                'nom' => 'BGFI',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2023-02-02 09:10:34',
            ),
            280 => 
            array (
                'id' => 1192,
                'abreviation' => NULL,
                'nom' => 'PROSPER SARL',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            281 => 
            array (
                'id' => 1193,
                'abreviation' => NULL,
                'nom' => 'KIBG',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            282 => 
            array (
                'id' => 1194,
                'abreviation' => NULL,
                'nom' => 'SYANG SYIBG',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            283 => 
            array (
                'id' => 1195,
                'abreviation' => NULL,
                'nom' => 'SBG ZENG DA',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            284 => 
            array (
                'id' => 1197,
                'abreviation' => 'CNSS',
                'nom' => 'CNSS NDJOLE',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2023-02-02 09:09:24',
            ),
            285 => 
            array (
                'id' => 1198,
                'abreviation' => NULL,
                'nom' => 'BSO - CNSS',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            286 => 
            array (
                'id' => 1199,
                'abreviation' => 'SEEG',
                'nom' => 'SEEG NTOUM',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2023-02-02 09:09:45',
            ),
            287 => 
            array (
                'id' => 1200,
                'abreviation' => NULL,
                'nom' => 'CIM - GABON',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            288 => 
            array (
                'id' => 1202,
                'abreviation' => NULL,
                'nom' => 'ARIANE',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            289 => 
            array (
                'id' => 1203,
                'abreviation' => 'SCIERIE MBIE',
                'nom' => 'SCIERIE MBIE',
                'created_at' => '2021-12-27 13:51:12',
                'updated_at' => '2021-12-27 13:51:12',
            ),
            290 => 
            array (
                'id' => 1204,
                'abreviation' => 'AICI GABON',
                'nom' => 'AICI GABON',
                'created_at' => '2022-01-12 07:56:21',
                'updated_at' => '2022-01-12 07:56:21',
            ),
            291 => 
            array (
                'id' => 1205,
                'abreviation' => 'alios gabon',
                'nom' => 'alios gabon',
                'created_at' => '2022-01-12 10:52:02',
                'updated_at' => '2022-01-12 10:52:02',
            ),
            292 => 
            array (
                'id' => 1206,
                'abreviation' => 'ANGT',
                'nom' => 'AGENCE NATIONALE  DES GRANDS TRAVAUX',
                'created_at' => '2022-01-13 10:15:42',
                'updated_at' => '2022-01-13 10:15:42',
            ),
            293 => 
            array (
                'id' => 1207,
                'abreviation' => 'CDC',
                'nom' => 'CAISSE DE DEPOT ET DE CONSIGNATIONS',
                'created_at' => '2022-01-13 10:18:39',
                'updated_at' => '2022-01-13 10:18:39',
            ),
            294 => 
            array (
                'id' => 1208,
                'abreviation' => 'BGFI BANK SA',
                'nom' => 'BGFI BANK SA',
                'created_at' => '2022-01-13 10:22:59',
                'updated_at' => '2022-01-13 10:22:59',
            ),
            295 => 
            array (
                'id' => 1209,
                'abreviation' => 'BOLORE TRANSIT ET LOGISTIC',
                'nom' => 'BOLORE TRANSIT ET LOGISTIC',
                'created_at' => '2022-01-13 10:36:13',
                'updated_at' => '2022-01-13 10:36:13',
            ),
            296 => 
            array (
                'id' => 1210,
                'abreviation' => 'CFA TECHNOLOGIES',
                'nom' => 'CFA TECHNOLOGIES',
                'created_at' => '2022-01-13 10:42:48',
                'updated_at' => '2022-01-13 10:42:48',
            ),
            297 => 
            array (
                'id' => 1211,
                'abreviation' => 'AMBASSADE DU BRESIL',
                'nom' => 'AMBASSADE DU BRESIL',
                'created_at' => '2022-01-14 07:31:35',
                'updated_at' => '2022-01-14 07:31:35',
            ),
            298 => 
            array (
                'id' => 1212,
                'abreviation' => 'AMBASSADE DU BOURKINA FASO',
                'nom' => 'AMBASSADE DU BOURKINA FASO',
                'created_at' => '2022-01-14 07:36:46',
                'updated_at' => '2022-01-14 07:36:46',
            ),
            299 => 
            array (
                'id' => 1213,
                'abreviation' => 'AMBASSADE DE TURQUIE',
                'nom' => 'AMBASSADE DE TURQUIE',
                'created_at' => '2022-01-14 07:38:34',
                'updated_at' => '2022-01-14 07:38:34',
            ),
            300 => 
            array (
                'id' => 1214,
                'abreviation' => 'EPC GABON',
                'nom' => 'EPC GABON',
                'created_at' => '2022-01-17 10:49:50',
                'updated_at' => '2022-01-17 10:49:50',
            ),
            301 => 
            array (
                'id' => 1215,
                'abreviation' => 'FONDATION ALBERTINE BONGO',
                'nom' => 'FONDATION ALBERTINE BONGO',
                'created_at' => '2022-01-17 10:51:21',
                'updated_at' => '2022-01-17 10:51:21',
            ),
            302 => 
            array (
                'id' => 1216,
                'abreviation' => 'SETRAG',
                'nom' => 'SETRAG',
                'created_at' => '2022-01-27 09:13:00',
                'updated_at' => '2022-01-27 09:13:00',
            ),
            303 => 
            array (
                'id' => 1217,
                'abreviation' => 'RADISSON BLU',
                'nom' => 'RADISSON BLU',
                'created_at' => '2022-02-15 09:01:09',
                'updated_at' => '2022-02-15 09:01:09',
            ),
            304 => 
            array (
                'id' => 1218,
                'abreviation' => 'GBX',
                'nom' => 'GABOPRIX',
                'created_at' => '2022-02-21 07:34:57',
                'updated_at' => '2023-02-02 09:08:49',
            ),
            305 => 
            array (
                'id' => 1220,
                'abreviation' => 'SGS BASE',
                'nom' => 'SGS BASE',
                'created_at' => '2022-10-31 12:56:45',
                'updated_at' => '2022-10-31 12:56:45',
            ),
        ));
        
        
    }
}