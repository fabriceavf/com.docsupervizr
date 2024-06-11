<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $villes = [
            "Lastrouville",
            "Owendo",
            "Akieni",
            "Libreville",
            "Port-Gentil",
            "Franceville",
            "Oyem",
            "Moanda",
            "Mouila",
            "Lambaréné",
            "Tchibanga",
            "Koulamoutou",
            "Makokou",
            "Bitam",
            "Tsogni",
            "Gamba",
            "Mounana",
            "Ntoum",
            "Nkan",
            "Lastourville",
            "Okondja",
            "Ndendé",
            "Booué",
            "Fougamou",
            "Ndjolé",
            "Mbigou",
            "Mayumba",
            "Mitzic",
            "Mékambo",
            "Lékoni",
            "Mimongo",
            "Minvoul",
            "Medouneu",
            "Omboué",
            "Cocobeach",
            "Kango",
        ];

        foreach ($villes as $ville) {
            Ville::create([
                'libelle' => $ville,
            ]);
        }
    }
}
