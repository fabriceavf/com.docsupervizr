<?php

namespace Database\Seeders;

use App\Models\Tache;
use Illuminate\Database\Seeder;

class TacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('typestaches')->delete();
        \DB::table('typestaches')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'libelle' => 'Collecte',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            1 =>
                array (
                    'id' => 2,
                    'libelle' => 'Atelier',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),
            2 =>
                array (
                    'id' => 3,
                    'libelle' => 'Administratif',
                    'extra_attributes' => NULL,
                    'created_at' => '2023-02-15 13:43:15',
                    'updated_at' => '2023-02-15 13:43:15',
                ),

        ));
        $zone1 = Tache::create([
            'libelle' => "Client privé",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone2 = Tache::create([
            'libelle' => "Mécanicien",
            'typestache_id' => 2,
            'ville_id' => "4",
        ]);

        $zone2->horaires()->createMany([
            [
                'libelle' => "20H-06H",
                'type' => "Nuit",
                'debut' => "20:00:00",
                'fin' => "06:00:00",
            ],
            [
                'libelle' => "07H30-17H30",
                'type' => "Jour",
                'debut' => "07:30:00",
                'fin' => "17:30:00",
            ],
            [
                'libelle' => "07H30-15H30",
                'type' => "Jour",
                'debut' => "07:30:00",
                'fin' => "15:30:00",
            ],
            [
                'libelle' => "09H00-17H00",
                'type' => "Jour",
                'debut' => "09:00:00",
                'fin' => "17:00:00",
            ],

        ]);

        $zone3 = Tache::create([
            'libelle' => "Vulcanisateur",
            'typestache_id' => 2,
            'ville_id' => "4",
        ]);

        $zone4 = Tache::create([
            'libelle' => "Porte à porte",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone5 = Tache::create([
            'libelle' => "Administratif",
            'typestache_id' => 3,
            'ville_id' => "4",
        ]);

        $zone5->horaires()->createMany([
            [
                'libelle' => "20H-06H",
                'type' => "Nuit",
                'debut' => "20:00:00",
                'fin' => "06:00:00",
            ],
            [
                'libelle' => "07H30-17H30",
                'type' => "Jour",
                'debut' => "07:30:00",
                'fin' => "17:30:00",
            ],
            [
                'libelle' => "07H30-15H30",
                'type' => "Jour",
                'debut' => "07:30:00",
                'fin' => "15:30:00",
            ]

        ]);

        $zone6 = Tache::create([
            'libelle' => "Electricien",
            'typestache_id' => 2,
            'ville_id' => "4",
        ]);

        $zone7 = Tache::create([
            'libelle' => "Collecte Bas et Bas de Gue Gue",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone8 = Tache::create([
            'libelle' => "Collecte Lalala-Rénovation-Plaine Niger",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone9 = Tache::create([
            'libelle' => "Collecte Okala",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone10 = Tache::create([
            'libelle' => "Collecte Boulevard Triomphal",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone11 = Tache::create([
            'libelle' => "Collecte Centre ville",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone12 = Tache::create([
            'libelle' => "Collecte VE PK5-IAI",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone13 = Tache::create([
            'libelle' => "Collecte Nzeng Ayong",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone14 = Tache::create([
            'libelle' => "Collecte C. SPECIAL",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone15 = Tache::create([
            'libelle' => "Collecte Marché Venez Voir",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);

        $zone16 = Tache::create([
            'libelle' => "Collecte Grappin 218",
            'typestache_id' => 1,
            'ville_id' => "4",
        ]);
    }
}
