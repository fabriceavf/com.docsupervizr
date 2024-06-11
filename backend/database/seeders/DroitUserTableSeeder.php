<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DroitUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('droit_user')->delete();
        
        \DB::table('droit_user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'droit_id' => 8,
                'user_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'droit_id' => 9,
                'user_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 8,
                'droit_id' => 8,
                'user_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 10,
                'droit_id' => 8,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 11,
                'droit_id' => 9,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 12,
                'droit_id' => 10,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 13,
                'droit_id' => 11,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 14,
                'droit_id' => 12,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 15,
                'droit_id' => 10,
                'user_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 16,
                'droit_id' => 11,
                'user_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 17,
                'droit_id' => 12,
                'user_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 18,
                'droit_id' => 8,
                'user_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 20,
                'droit_id' => 8,
                'user_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 22,
                'droit_id' => 9,
                'user_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 23,
                'droit_id' => 9,
                'user_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 24,
                'droit_id' => 9,
                'user_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 25,
                'droit_id' => 8,
                'user_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 26,
                'droit_id' => 9,
                'user_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 27,
                'droit_id' => 8,
                'user_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 28,
                'droit_id' => 9,
                'user_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 29,
                'droit_id' => 8,
                'user_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 30,
                'droit_id' => 9,
                'user_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 31,
                'droit_id' => 8,
                'user_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 32,
                'droit_id' => 9,
                'user_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 33,
                'droit_id' => 8,
                'user_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 34,
                'droit_id' => 9,
                'user_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 35,
                'droit_id' => 8,
                'user_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 36,
                'droit_id' => 9,
                'user_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 37,
                'droit_id' => 10,
                'user_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 38,
                'droit_id' => 11,
                'user_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 39,
                'droit_id' => 12,
                'user_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 40,
                'droit_id' => 8,
                'user_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 41,
                'droit_id' => 9,
                'user_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 42,
                'droit_id' => 10,
                'user_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 43,
                'droit_id' => 8,
                'user_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 44,
                'droit_id' => 9,
                'user_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 45,
                'droit_id' => 8,
                'user_id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 46,
                'droit_id' => 9,
                'user_id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 47,
                'droit_id' => 8,
                'user_id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 48,
                'droit_id' => 9,
                'user_id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 49,
                'droit_id' => 8,
                'user_id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 50,
                'droit_id' => 9,
                'user_id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 51,
                'droit_id' => 8,
                'user_id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 52,
                'droit_id' => 9,
                'user_id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 53,
                'droit_id' => 8,
                'user_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 54,
                'droit_id' => 9,
                'user_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 55,
                'droit_id' => 8,
                'user_id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 56,
                'droit_id' => 9,
                'user_id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 57,
                'droit_id' => 8,
                'user_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 58,
                'droit_id' => 9,
                'user_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 59,
                'droit_id' => 8,
                'user_id' => 26,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 60,
                'droit_id' => 9,
                'user_id' => 26,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 61,
                'droit_id' => 8,
                'user_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 62,
                'droit_id' => 9,
                'user_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 63,
                'droit_id' => 8,
                'user_id' => 28,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 64,
                'droit_id' => 9,
                'user_id' => 28,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 65,
                'droit_id' => 8,
                'user_id' => 29,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 66,
                'droit_id' => 9,
                'user_id' => 29,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 67,
                'droit_id' => 8,
                'user_id' => 30,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 68,
                'droit_id' => 9,
                'user_id' => 30,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 69,
                'droit_id' => 8,
                'user_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 70,
                'droit_id' => 9,
                'user_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 71,
                'droit_id' => 10,
                'user_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 72,
                'droit_id' => 11,
                'user_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 73,
                'droit_id' => 8,
                'user_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 74,
                'droit_id' => 9,
                'user_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 75,
                'droit_id' => 8,
                'user_id' => 33,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 76,
                'droit_id' => 9,
                'user_id' => 33,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 77,
                'droit_id' => 8,
                'user_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 78,
                'droit_id' => 8,
                'user_id' => 35,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 79,
                'droit_id' => 10,
                'user_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 80,
                'droit_id' => 11,
                'user_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 81,
                'droit_id' => 12,
                'user_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 82,
                'droit_id' => 9,
                'user_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 83,
                'droit_id' => 10,
                'user_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 84,
                'droit_id' => 11,
                'user_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 85,
                'droit_id' => 12,
                'user_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 86,
                'droit_id' => 8,
                'user_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 87,
                'droit_id' => 9,
                'user_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 88,
                'droit_id' => 11,
                'user_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 89,
                'droit_id' => 8,
                'user_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 90,
                'droit_id' => 9,
                'user_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 91,
                'droit_id' => 11,
                'user_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 92,
                'droit_id' => 8,
                'user_id' => 38,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 93,
                'droit_id' => 9,
                'user_id' => 38,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 94,
                'droit_id' => 10,
                'user_id' => 38,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 95,
                'droit_id' => 11,
                'user_id' => 38,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 96,
                'droit_id' => 12,
                'user_id' => 38,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 97,
                'droit_id' => 8,
                'user_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 98,
                'droit_id' => 9,
                'user_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 99,
                'droit_id' => 10,
                'user_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 100,
                'droit_id' => 11,
                'user_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 101,
                'droit_id' => 12,
                'user_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 102,
                'droit_id' => 8,
                'user_id' => 41,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 103,
                'droit_id' => 9,
                'user_id' => 41,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 104,
                'droit_id' => 10,
                'user_id' => 41,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 105,
                'droit_id' => 11,
                'user_id' => 41,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 106,
                'droit_id' => 12,
                'user_id' => 41,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 107,
                'droit_id' => 8,
                'user_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 108,
                'droit_id' => 9,
                'user_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 109,
                'droit_id' => 10,
                'user_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 110,
                'droit_id' => 11,
                'user_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 111,
                'droit_id' => 12,
                'user_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 112,
                'droit_id' => 9,
                'user_id' => 43,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 113,
                'droit_id' => 8,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 114,
                'droit_id' => 9,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 115,
                'droit_id' => 10,
                'user_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 116,
                'droit_id' => 11,
                'user_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 117,
                'droit_id' => 12,
                'user_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 118,
                'droit_id' => NULL,
                'user_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 119,
                'droit_id' => 11,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 120,
                'droit_id' => 10,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 121,
                'droit_id' => 12,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 122,
                'droit_id' => NULL,
                'user_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}