<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FonctionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fonctions')->delete();
        
        \DB::table('fonctions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'AGENT DE SECURITE',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'GARDE DE CORPS',
                'created_at' => '2021-11-11 08:36:37',
                'updated_at' => '2021-11-11 08:36:37',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'SUPERVISEUR',
                'created_at' => '2021-11-11 08:36:38',
                'updated_at' => '2021-11-11 08:36:38',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'RESPONSABLE',
                'created_at' => '2021-11-11 08:36:38',
                'updated_at' => '2021-11-11 08:36:38',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => 'SUPERVISEUR GENERAL',
                'created_at' => '2021-11-11 08:36:38',
                'updated_at' => '2021-11-11 08:36:38',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => 'TECHNICIENNE DE SURFACE',
                'created_at' => '2021-12-14 07:27:18',
                'updated_at' => '2021-12-14 07:27:18',
            ),
            6 => 
            array (
                'id' => 7,
                'libelle' => 'TECHNICIEN DNT',
                'created_at' => '2021-12-14 07:27:35',
                'updated_at' => '2021-12-14 07:27:35',
            ),
            7 => 
            array (
                'id' => 8,
                'libelle' => 'TECHNICIEN DE TELESURVEILLANCE',
                'created_at' => '2021-12-14 07:28:19',
                'updated_at' => '2021-12-14 07:28:19',
            ),
            8 => 
            array (
                'id' => 9,
                'libelle' => 'DIRECTEUR TECHNIQUE',
                'created_at' => '2021-12-14 07:28:19',
                'updated_at' => '2021-12-14 07:28:19',
            ),
            9 => 
            array (
                'id' => 10,
                'libelle' => 'SUPERVISEUR-ADJOINT',
                'created_at' => '2021-12-14 07:29:42',
                'updated_at' => '2021-12-14 07:29:42',
            ),
            10 => 
            array (
                'id' => 11,
                'libelle' => 'SUPERVISEUR DE ZONE',
                'created_at' => '2021-12-14 07:29:42',
                'updated_at' => '2021-12-14 07:29:42',
            ),
            11 => 
            array (
                'id' => 12,
                'libelle' => 'RESPONSABLE MISE EN PLACE
',
                'created_at' => '2021-12-14 07:29:42',
                'updated_at' => '2021-12-14 07:29:42',
            ),
            12 => 
            array (
                'id' => 13,
                'libelle' => 'RESPONSABLE ARMURERIE',
                'created_at' => '2021-12-14 07:29:42',
                'updated_at' => '2021-12-14 07:29:42',
            ),
            13 => 
            array (
                'id' => 14,
                'libelle' => 'RECEPTIONNISTE ACCUEIL ',
                'created_at' => '2021-12-14 07:31:41',
                'updated_at' => '2021-12-14 07:31:41',
            ),
            14 => 
            array (
                'id' => 15,
                'libelle' => 'POMPIER',
                'created_at' => '2021-12-14 07:32:00',
                'updated_at' => '2021-12-14 07:32:00',
            ),
            15 => 
            array (
                'id' => 16,
                'libelle' => 'OPERATEUR RADIO',
                'created_at' => '2021-12-14 07:32:00',
                'updated_at' => '2021-12-14 07:32:00',
            ),
            16 => 
            array (
                'id' => 17,
                'libelle' => 'MAITRE - CHIEN',
                'created_at' => '2021-12-14 07:32:00',
                'updated_at' => '2021-12-14 07:32:00',
            ),
            17 => 
            array (
                'id' => 18,
                'libelle' => 'CONVOYEUR DE FONDS',
                'created_at' => '2021-12-14 07:33:56',
                'updated_at' => '2021-12-14 07:33:56',
            ),
            18 => 
            array (
                'id' => 19,
                'libelle' => 'CONTROLEUR',
                'created_at' => '2021-12-14 07:33:56',
                'updated_at' => '2021-12-14 07:33:56',
            ),
            19 => 
            array (
                'id' => 20,
                'libelle' => 'RESPONSABLE DE SECTION',
                'created_at' => '2021-12-14 07:33:56',
                'updated_at' => '2021-12-14 07:33:56',
            ),
            20 => 
            array (
                'id' => 21,
                'libelle' => 'COMPTABLE',
                'created_at' => '2021-12-14 07:33:56',
                'updated_at' => '2021-12-14 07:33:56',
            ),
            21 => 
            array (
                'id' => 22,
                'libelle' => 'CHEF STATION RADIO',
                'created_at' => '2021-12-14 07:33:56',
                'updated_at' => '2021-12-14 07:33:56',
            ),
            22 => 
            array (
                'id' => 23,
                'libelle' => 'ARCHIVISTE',
                'created_at' => '2021-12-14 07:36:51',
                'updated_at' => '2021-12-14 07:36:51',
            ),
            23 => 
            array (
                'id' => 24,
                'libelle' => 'ARMURIER',
                'created_at' => '2021-12-14 07:36:51',
                'updated_at' => '2021-12-14 07:36:51',
            ),
            24 => 
            array (
                'id' => 25,
                'libelle' => 'ASSISTANT',
                'created_at' => '2021-12-14 10:57:36',
                'updated_at' => '2021-12-14 10:57:36',
            ),
            25 => 
            array (
                'id' => 26,
                'libelle' => 'GESTIONNAIRE',
                'created_at' => '2021-12-14 11:02:24',
                'updated_at' => '2021-12-14 11:02:24',
            ),
            26 => 
            array (
                'id' => 27,
                'libelle' => 'COORDINATEUR GENERAL',
                'created_at' => '2021-12-14 20:43:32',
                'updated_at' => '2021-12-14 20:43:32',
            ),
            27 => 
            array (
                'id' => 28,
                'libelle' => 'DIRECTEUR GENERAL',
                'created_at' => '2021-12-14 20:47:32',
                'updated_at' => '2021-12-14 20:47:32',
            ),
            28 => 
            array (
                'id' => 29,
                'libelle' => 'RESPONSABLE DE DEPARTEMENT',
                'created_at' => '2021-12-14 21:00:43',
                'updated_at' => '2021-12-14 21:00:43',
            ),
            29 => 
            array (
                'id' => 30,
                'libelle' => 'DIRECTEUR TECHNIQUE ADJOINT',
                'created_at' => '2021-12-14 21:00:43',
                'updated_at' => '2021-12-14 21:00:43',
            ),
            30 => 
            array (
                'id' => 31,
                'libelle' => 'DIRECTEUR FINANCIER',
                'created_at' => '2021-12-14 21:02:05',
                'updated_at' => '2021-12-14 21:02:05',
            ),
            31 => 
            array (
                'id' => 32,
                'libelle' => 'DIRECTEUR DES RESSOURCES HUMAINES',
                'created_at' => '2021-12-14 21:02:30',
                'updated_at' => '2021-12-14 21:02:30',
            ),
            32 => 
            array (
                'id' => 33,
                'libelle' => 'DIRECTEUR DES SYSTEMES D’INFORMATION',
                'created_at' => '2021-12-14 21:02:30',
                'updated_at' => '2021-12-14 21:02:30',
            ),
            33 => 
            array (
                'id' => 34,
                'libelle' => 'DIRECTEUR REGIONAL',
                'created_at' => '2021-12-14 21:02:30',
                'updated_at' => '2021-12-14 21:02:30',
            ),
            34 => 
            array (
                'id' => 35,
                'libelle' => 'OPERATEUR VIDEO-TELESURVEILLANCE',
                'created_at' => '2021-12-14 21:12:00',
                'updated_at' => '2021-12-14 21:12:00',
            ),
            35 => 
            array (
                'id' => 36,
                'libelle' => 'HUISSIER',
                'created_at' => '2021-12-14 21:12:00',
                'updated_at' => '2021-12-14 21:12:00',
            ),
            36 => 
            array (
                'id' => 37,
            'libelle' => 'INFIRMIER (E)',
                'created_at' => '2021-12-14 21:12:00',
                'updated_at' => '2021-12-14 21:12:00',
            ),
            37 => 
            array (
                'id' => 38,
                'libelle' => 'INFORMATICIEN',
                'created_at' => '2021-12-14 21:12:00',
                'updated_at' => '2021-12-14 21:12:00',
            ),
            38 => 
            array (
                'id' => 39,
                'libelle' => 'JURISTE',
                'created_at' => '2021-12-14 21:12:00',
                'updated_at' => '2021-12-14 21:12:00',
            ),
            39 => 
            array (
                'id' => 40,
                'libelle' => 'EXPERT SECURITE',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            40 => 
            array (
                'id' => 41,
                'libelle' => 'FORMATEUR',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            41 => 
            array (
                'id' => 42,
            'libelle' => 'ASSISTANT (E) DE DIRECTION',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            42 => 
            array (
                'id' => 43,
                'libelle' => 'AGENT COMMERCIAL',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            43 => 
            array (
                'id' => 44,
                'libelle' => 'AGENT DE SURETE',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            44 => 
            array (
                'id' => 45,
                'libelle' => 'AMBULANCIER',
                'created_at' => '2021-12-14 21:14:49',
                'updated_at' => '2021-12-14 21:14:49',
            ),
            45 => 
            array (
                'id' => 46,
                'libelle' => 'COORDINATEUR',
                'created_at' => '2021-12-14 21:19:43',
                'updated_at' => '2021-12-14 21:19:43',
            ),
            46 => 
            array (
                'id' => 47,
            'libelle' => 'CAISSIER(E)',
                'created_at' => '2021-12-14 21:19:43',
                'updated_at' => '2021-12-14 21:19:43',
            ),
            47 => 
            array (
                'id' => 48,
                'libelle' => 'CHAUFFEUR DE LIAISON',
                'created_at' => '2021-12-14 21:19:43',
                'updated_at' => '2021-12-14 21:19:43',
            ),
            48 => 
            array (
                'id' => 49,
                'libelle' => 'CHAUFFEUR',
                'created_at' => '2021-12-14 21:19:43',
                'updated_at' => '2021-12-14 21:19:43',
            ),
            49 => 
            array (
                'id' => 50,
                'libelle' => 'CHAUFFEUR TF',
                'created_at' => '2021-12-14 21:19:43',
                'updated_at' => '2021-12-14 21:19:43',
            ),
            50 => 
            array (
                'id' => 51,
                'libelle' => 'CHEF DU PERSONNEL',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            51 => 
            array (
                'id' => 52,
                'libelle' => 'CHEF D’AGENCE',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            52 => 
            array (
                'id' => 53,
                'libelle' => 'CHEF COMPTABLE',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            53 => 
            array (
                'id' => 54,
                'libelle' => 'CHEF COMPTABLE ADJOINT',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            54 => 
            array (
                'id' => 55,
                'libelle' => 'CHEF DE SERVICE',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            55 => 
            array (
                'id' => 56,
                'libelle' => 'CHEF DE SERVICE ADJOINT',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            56 => 
            array (
                'id' => 57,
                'libelle' => 'CHEF D’EQUIPE',
                'created_at' => '2021-12-14 21:22:17',
                'updated_at' => '2021-12-14 21:22:17',
            ),
            57 => 
            array (
                'id' => 58,
                'libelle' => 'CHEF D’EQUIPE ADJOINT',
                'created_at' => '2021-12-14 21:25:05',
                'updated_at' => '2021-12-14 21:25:05',
            ),
            58 => 
            array (
                'id' => 59,
                'libelle' => 'Equipier Tf',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            59 => 
            array (
                'id' => 60,
                'libelle' => 'Chef D Equipe',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            60 => 
            array (
                'id' => 61,
                'libelle' => 'Chef D\'equipe',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            61 => 
            array (
                'id' => 62,
                'libelle' => 'Responsable Reclemation Et Pointage',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            62 => 
            array (
                'id' => 63,
                'libelle' => 'Resonsable Mep',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            63 => 
            array (
                'id' => 64,
                'libelle' => 'Chef D`equipe Tf',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            64 => 
            array (
                'id' => 65,
                'libelle' => 'Element Tf',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            65 => 
            array (
                'id' => 66,
                'libelle' => 'Pharmacie Magalie',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            66 => 
            array (
                'id' => 67,
                'libelle' => 'Chef D`equipe',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            67 => 
            array (
                'id' => 68,
                'libelle' => 'Assistant Rh',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            68 => 
            array (
                'id' => 69,
                'libelle' => 'Assistante Rh',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            69 => 
            array (
                'id' => 70,
                'libelle' => 'Responsable Rh',
                'created_at' => '2021-12-21 09:46:14',
                'updated_at' => '2021-12-21 09:46:14',
            ),
            70 => 
            array (
                'id' => 71,
                'libelle' => 'Agent Tf',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            71 => 
            array (
                'id' => 72,
                'libelle' => 'Chef De Camp',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            72 => 
            array (
                'id' => 73,
                'libelle' => 'Responsable Mise En Place',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            73 => 
            array (
                'id' => 74,
                'libelle' => 'Garde Du Corps ',
                'created_at' => '2021-12-21 09:46:15',
                'updated_at' => '2021-12-21 09:46:15',
            ),
            74 => 
            array (
                'id' => 75,
                'libelle' => 'CHEF DE ZONE',
                'created_at' => '2022-01-13 14:22:58',
                'updated_at' => '2022-01-13 14:22:58',
            ),
            75 => 
            array (
                'id' => 76,
                'libelle' => 'Responsable de la facturation et du recouvrement',
                'created_at' => '2022-02-03 11:46:36',
                'updated_at' => '2022-02-03 11:46:36',
            ),
            76 => 
            array (
                'id' => 77,
                'libelle' => 'Correspondant RH',
                'created_at' => '2022-10-25 09:46:56',
                'updated_at' => '2022-10-25 09:46:56',
            ),
            77 => 
            array (
                'id' => 78,
                'libelle' => 'Gestionnaire Pointage',
                'created_at' => '2022-11-03 09:25:33',
                'updated_at' => '2022-11-03 09:25:33',
            ),
            78 => 
            array (
                'id' => 79,
                'libelle' => 'Assistante DT',
                'created_at' => '2022-11-08 14:34:20',
                'updated_at' => '2022-11-08 14:34:20',
            ),
            79 => 
            array (
                'id' => 80,
                'libelle' => 'Directeur d\'agence',
                'created_at' => '2022-11-10 11:06:38',
                'updated_at' => '2022-11-10 11:06:38',
            ),
            80 => 
            array (
                'id' => 81,
                'libelle' => 'DIRECTEUR QHSE',
                'created_at' => '2022-11-11 09:55:53',
                'updated_at' => '2022-11-11 09:55:53',
            ),
            81 => 
            array (
                'id' => 82,
                'libelle' => 'DIRECTEUR TAEF',
                'created_at' => '2022-11-14 09:42:11',
                'updated_at' => '2022-11-14 09:42:11',
            ),
            82 => 
            array (
                'id' => 83,
                'libelle' => 'GI',
                'created_at' => '2022-11-21 14:05:15',
                'updated_at' => '2022-11-21 14:05:15',
            ),
            83 => 
            array (
                'id' => 84,
                'libelle' => 'Mécanicien',
                'created_at' => '2022-12-29 14:17:09',
                'updated_at' => '2022-12-29 14:17:09',
            ),
            84 => 
            array (
                'id' => 85,
                'libelle' => 'GI STATIQUE',
                'created_at' => '2023-01-30 09:48:32',
                'updated_at' => '2023-01-30 09:48:32',
            ),
        ));
        
        
    }
}