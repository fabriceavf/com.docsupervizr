<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActivityLogTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activity_log')->delete();
        
        
        
    }
}