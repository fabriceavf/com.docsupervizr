<?php


namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UserSeeder extends Seeder

{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()

    {

        $d1 = User::create([

            'name' => "Justinho Mikala",

            'email' => 'dev@gabontech.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'type' => 'admin'

        ]);


        $d2 = User::create([

            'name' => "User Demo",

            'email' => 'demo@cleanafrica.net',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'type' => 'admin'

        ]);


        $d7 = User::create([

            'matricule' => "0929",

            'name' => "OKOSSI OMBINDA Wilfried Fiacre",

            'email' => 'employe7@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "OKOSSI OMBINDA ",

            'prenom' => "Wilfried Fiacre",

            'emp_code' => "7",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d8 = User::create([

            'matricule' => "1322",

            'name' => "MANFOUMBY Wulfrand",

            'email' => 'employe8@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "MANFOUMBY ",

            'prenom' => "Wulfrand",

            'emp_code' => "8",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d9 = User::create([

            'matricule' => "1077",

            'name' => "NINGONE Amélie",

            'email' => 'employe9@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "NINGONE ",

            'prenom' => "Amélie",

            'emp_code' => "9",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d10 = User::create([

            'matricule' => "1121",

            'name' => "BETOUE Abigaël Nancy",

            'email' => 'employe10@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "BETOUE",

            'prenom' => "Abigaël Nancy",

            'emp_code' => "10",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d11 = User::create([

            'matricule' => "1131",

            'name' => "TCHIBINDA TATY Ornela",

            'email' => 'employe11@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "TCHIBINDA TATY",

            'prenom' => "Ornela",

            'emp_code' => "11",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d12 = User::create([

            'matricule' => "0930",

            'name' => "GOMES AGUERO",

            'email' => 'employe12@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "GOMES",

            'prenom' => "AGUERO",

            'emp_code' => "12",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d13 = User::create([

            'matricule' => "1371",

            'name' => "MAMFOUMBI Welcome Steve",

            'email' => 'employe13@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "MAMFOUMBI",

            'prenom' => "Welcome Steve",

            'emp_code' => "13",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d14 = User::create([

            'matricule' => "1623",

            'name' => "MABICKA MABICKA Laure",

            'email' => 'employe14@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "MABICKA MABICKA",

            'prenom' => "Laure",

            'emp_code' => "14",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d15 = User::create([

            'matricule' => "1365",

            'name' => "DJIMBIRI Eric",

            'email' => 'employe15@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "DJIMBIRI",

            'prenom' => "Eric",

            'emp_code' => "15",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d16 = User::create([

            'matricule' => "0057",

            'name' => "MENGUEY Epse MACKANGA Joelle",

            'email' => 'employe16@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "MENGUEY Epse MACKANGA",

            'prenom' => "Joelle",

            'emp_code' => "16",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d17 = User::create([

            'matricule' => "1351",

            'name' => "NGAMBOUO Ervess",

            'email' => 'employe17@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "NGAMBOUO",

            'prenom' => "Ervess",

            'emp_code' => "17",

            'actif' => "1",

            'type' => 'employe',

            'fonction_id' => "1",

        ]);


        $d18 = User::create([

            'matricule' => "0767",

            'name' => "NZAME AKOMA Prisca",

            'email' => 'employe18@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "NZAME AKOMA",

            'prenom' => "Prisca",

            'emp_code' => "18",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d19 = User::create([

            'matricule' => "1520",

            'name' => "MILAME MI NDONG Pierre",

            'email' => 'employe19@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "MILAME MI NDONG",

            'prenom' => "Pierre",

            'emp_code' => "19",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);


        $d20 = User::create([

            'matricule' => "1446",

            'name' => "NZE Fabrice Ivano.",

            'email' => 'employe20@clean-africa.com',

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),

            'nom' => "NZE",

            'prenom' => "Fabrice Ivano",

            'emp_code' => "20",

            'fonction_id' => "1",

            'actif' => "1",

            'type' => 'employe'

        ]);

    }

}

