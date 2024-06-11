<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variables')->delete();

        Variable::create([
            'libelle' => "oui",
        ]);

        Variable::create([
            'libelle' => "non",
        ]);
    }
}
