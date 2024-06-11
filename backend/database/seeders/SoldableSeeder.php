<?php

namespace Database\Seeders;

use App\Models\Soldable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SoldableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('soldables')->delete();
        Soldable::create([
            'libelle' => "oui",
        ]);

        Soldable::create([
            'libelle' => "non",
        ]);
    }
}
