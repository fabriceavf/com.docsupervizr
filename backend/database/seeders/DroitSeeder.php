<?php

namespace Database\Seeders;

use App\Models\Droit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DroitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Droit::create([
            'libelle' => 'CreerEnrolement',
            'description' => 'Le droit sur la création d\'un nouvel agent',
        ]);

        Droit::create([
            'libelle' => 'ModifierEnrolement',
            'description' => 'Le droit sur la modification du dossier d\'un agent',
        ]);

        Droit::create([
            'libelle' => 'ValiderEnrolement',
            'description' => 'Le droit sur la validation de l\'enrolement d\'un nouvel agent',
        ]);

        Droit::create([
            'libelle' => 'AffecterBadge',
            'description' => 'Le droit sur l\'ajout d\'un badge dans le dossier d\'un agent',
        ]);

        Droit::create([
            'libelle' => 'SupprimerEnrolement',
            'description' => 'Le droit sur la suppression d\'un agent',
        ]);

        Droit::create([
            'libelle' => 'CreerPoste',
            'description' => 'Le droit sur la création d\'un poste',
        ]);

        Droit::create([
            'libelle' => 'ModifierPoste',
            'description' => 'Le droit sur la modification d\'une fiche de poste',
        ]);

        Droit::create([
            'libelle' => 'CreerPointage',
            'description' => 'Le droit sur la création d\'un pointage manuel',
        ]);

        Droit::create([
            'libelle' => 'ValiderPointage1',
            'description' => 'Le droit sur la validation d\'un pointage au niveau 1',
        ]);

        Droit::create([
            'libelle' => 'ValiderPointage2',
            'description' => 'Le droit sur la validation d\'un pointage au niveau 2',
        ]);

        Droit::create([
            'libelle' => 'ConsulterPointage',
            'description' => 'Le droit sur la gestion des pointages (journal & rapports)',
        ]);

        Droit::create([
            'libelle' => 'ConsulterCarte',
            'description' => 'Le droit sur la consultation des positions sur la carte',
        ]);

        Droit::create([
            'libelle' => 'GestionRessources',
            'description' => 'Le droit sur la creation et modifications des ressources (clients, fonctions,etc)',
        ]);
    }
}
