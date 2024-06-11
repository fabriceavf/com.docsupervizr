<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('types')->delete();
        \DB::table('types')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'libelle' => 'Admin',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            1 =>
                array (
                    'id' => 2,
                    'libelle' => 'Employe',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),

        ));
    }
}
