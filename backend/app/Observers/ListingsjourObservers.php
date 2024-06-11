<?php

namespace App\Observers;

use App\Models\Listingsjour;
use Illuminate\Support\Facades\DB;
use Throwable;


class ListingsjourObservers
{
    /**
     * Handle the Listingsjourss "created" event.
     *
     * @param Listingsjour $listingsjour
     * @return void
     */
    public static function created(Listingsjour $listingsjour)
    {
        $extra = [];
        try {
            $extra = $listingsjour->extra_attributes['extra-data'];

        } catch (Throwable $e) {
        }
        if (!is_array($extra)) {
            $extra = [];
        }

        $poste_id = 0;
        try {
            $poste_id = $listingsjour->extra_attributes['extra-data']['poste_id'];
        } catch (Throwable $e) {
        }
        $faction = '';
        try {
            $faction = $listingsjour->extra_attributes['extra-data']['faction'];
        } catch (Throwable $e) {
        }
        if (array_key_exists('users', $extra)) {
            $users = collect($extra['users'])->map(function ($data) use ($poste_id) {
                return [
                    "user_id" => $data,
                    "poste_id" => $poste_id,
                ];
            });
        }
        if (array_key_exists('usersWithPostes', $extra)) {
            $users = collect($extra['usersWithPostes'])->map(function ($data) {
                return [
                    "user_id" => $data['user_id'],
                    "poste_id" => $data['poste_id'],
                ];
            });
        }


//        on creer une programmation virtuel pour le listing actuel
        $programmation = DB::table('programmations')->insertGetId([
            'libelle' => $listingsjour->libelle,
            'description' => '',
            'date_debut' => $listingsjour->date,
            'date_fin' => $listingsjour->date,
            'default_heure_debut' => "00:00:00",
            'default_heure_fin' => '23:59:00',
            'user_id' => $listingsjour->user,
            'faction' => $faction,
            'statut' => 'valider',
            'type' => 'listings-' . $listingsjour->etats,
        ]);
        $horaire = DB::table('horaires')->insertGetId(array(
            'libelle' => '00H-23H59',
            'debut' => '00:00:00',
            'fin' => '23:59:00',
            'tolerance' => '0',
            'type' => 'Jour',
            'tache_id' => 0,
            'extra_attributes' => NULL,
            'created_at' => now(),
            'updated_at' => now(),
        ));

        foreach ($users as $user) {
            $programmationsuser = DB::table('programmationsusers')->insertGetId([
                'user_id' => $user['user_id'],
                'programmation_id' => $programmation,
            ]);
            $programme = DB::table('programmes')->insertGetId([
                'programmationsuser_id' => $programmationsuser,
                'date' => $listingsjour->date,
                'debut_prevu' => $listingsjour->date . " 00:00:00",
                'fin_prevu' => $listingsjour->date . " 23:59:00",
                'horaire_id' => $horaire,
                'poste_id' => $user['poste_id'],
            ]);

        }

        DB::table('transactions')
            ->where('punch_date', $listingsjour->date)
            ->update('traiter', 0);
    }

    /**
     * Handle the Listingsjourss "updated" event.
     *
     * @param Listingsjour $listingsjour
     * @return void
     */
    public static function updated(Listingsjour $listingsjour)
    {
//        if ($listingsjour->etats == 'cloturer') {
//            foreach (Listing::where([
//                'id_date' => $listingsjour->id,
//                'present' => 'oui',
//            ])->cursor() as $data) {
//                $faction = 'jour';
//                try {
//                    $user = User::find($data->id_user);
//                    $faction = $user->faction->libelle;
//                } catch (Throwable $e) {
//
//                }
//                if ($faction == 'jour') {
//                    $debut = '07:00:00';
//                } else if ($faction == 'nuit') {
//                    $debut = '21:00:00';
//                } else {
//                    $debut = '00:00:00';
//                }
//                $_data = [];
//                $date = explode(' ', $data->date)[0];
//                $_data['bio_id'] = $data->id;
//                $_data['area_alias'] = 'fictif-0';
//                $_data['first_name'] = $data->nom;
//                $_data['last_name'] = $data->prenom;
//                $_data['card_no'] = $data->num_badge;
//                $_data['terminal_alias'] = 'fictif-0';
//                $_data['emp_code'] = $data->num_badge;
//                $_data['punch_date'] = $date;
//                $_data['punch_time'] = $date . ' ' . $debut;
//                $_data['created_at'] = now();
//                DB::table('transactions')->updateOrInsert(['bio_id' => $data->id], $_data);
//            }
//        }

    }

    /**
     * Handle the Listingsjourss "deleted" event.
     *
     * @param Listingsjour $listingsjour
     * @return void
     */
    public static function deleted(Listingsjour $listingsjour)
    {


    }

    /**
     * Handle the Listingsjourss "restored" event.
     *
     * @param Listingsjour $listingsjour
     * @return void
     */
    public static function restored(Listingsjour $listingsjour)
    {
//
    }

    /**
     * Handle the Listingsjourss "force deleted" event.
     *
     * @param Listingsjour $listingsjour
     * @return void
     */
    public static function forceDeleted(Listingsjour $listingsjour)
    {
//


    }
}
