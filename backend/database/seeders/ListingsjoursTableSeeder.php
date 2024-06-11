<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListingsjoursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('listingsjours')->delete();
        for($i = 10 ; $i <= 30 ; $i++){
        \DB::table('listingsjours')->insert([
                [
                    'date' => '2023-01-'.$i,

                    'created_at' => '2021-12-12 19:44:47',
                    'updated_at' => '2021-12-12 19:44:47',
                ]
            ]

        );}


    }
}
