<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        \DB::table('oauth_clients')->delete();

        \DB::table('oauth_clients')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => 'vJEjHOukcZDosVmogCbxmjXohEP3OkfrniCebIEh',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-05-06 09:41:54',
                'updated_at' => '2023-05-06 09:41:54',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Supervizr Password Grant Client',
                'secret' => 'T7TXOhvUSNw8jEaOOhRlQ2ao865ogxHFhEu8E5bu',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2023-05-06 09:41:54',
                'updated_at' => '2023-05-06 09:41:54',
            ),
            2 =>
            array (
                'id' => 3,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => '4vWUBYcn0DB4hKjZho6a5pHToZt9bGculKdDUdcV',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-05-06 11:30:07',
                'updated_at' => '2023-05-06 11:30:07',
            ),
            3 =>
            array (
                'id' => 4,
                'user_id' => NULL,
                'name' => 'Supervizr Password Grant Client',
                'secret' => 'st2fOgn0Bnd0acmDvnvvUFLAbsquYLaLYUpDZmgl',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2023-05-06 11:30:07',
                'updated_at' => '2023-05-06 11:30:07',
            ),
            4 =>
            array (
                'id' => 5,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => 'cIrrFJuqkzW8zmwHDOWUVlrGXG8bxleXVC0b9RLh',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-06-15 10:25:47',
                'updated_at' => '2023-06-15 10:25:47',
            ),
            5 =>
            array (
                'id' => 6,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => 'l10cIhTKnGWFyAR8pUdjmg1bfXkHvjJTOTdYDRgZ',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-07-10 07:21:10',
                'updated_at' => '2023-07-10 07:21:10',
            ),
            6 =>
            array (
                'id' => 7,
                'user_id' => NULL,
                'name' => 'Supervizr Password Grant Client',
                'secret' => 'U8LBDI8wstWQrEFvqdsaCLoX4enXYEUBuqGfrCnh',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2023-07-10 07:21:10',
                'updated_at' => '2023-07-10 07:21:10',
            ),
            7 =>
            array (
                'id' => 8,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => '2q5NH8oKFoqgIxb1ai1s7IVOUyhA7Rn2oAvklPmt',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-07-10 07:23:07',
                'updated_at' => '2023-07-10 07:23:07',
            ),
            8 =>
            array (
                'id' => 9,
                'user_id' => NULL,
                'name' => 'Default password grant client',
                'secret' => 'nEYLNFFAwZU3JCKPvYa7664itiZ3jL0COwgN92vF',
                'provider' => NULL,
                'redirect' => 'http://your.redirect.path',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2023-07-19 09:39:48',
                'updated_at' => '2023-07-19 09:39:48',
            ),
            9 =>
            array (
                'id' => 10,
                'user_id' => NULL,
                'name' => 'Default personal access client',
                'secret' => 'kfZ2fGHj7Gxj0X1AUNdiPsKIlgNcKvRxsOJRFPHT',
                'provider' => NULL,
                'redirect' => 'http://your.redirect.path',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-07-19 09:39:48',
                'updated_at' => '2023-07-19 09:39:48',
            ),
            10 =>
            array (
                'id' => 11,
                'user_id' => NULL,
                'name' => 'Supervizr Personal Access Client',
                'secret' => '2vdfK0CDCbSloOHmZnWISUl54F6K1i6ikbuTpVvN',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2023-07-19 09:45:13',
                'updated_at' => '2023-07-19 09:45:13',
            ),
        ));


    }
}
