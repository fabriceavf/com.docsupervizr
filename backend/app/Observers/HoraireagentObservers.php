<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Horaireagent;
use Illuminate\Support\Facades\DB;


class HoraireagentObservers
{
    /**
     * Handle the Horaires "created" event.
     *
     * @param Horaireagent $horaireagent
     * @return void
     */
    public static function created(Horaireagent $horaireagent)
    {

        self::updateUserPostes($horaireagent);

        $poste_id = DB::table('horaires')
            ->where('horaires.id', $horaireagent->horaire_id)
            ->pluck('poste_id');
        // ->pluck('postes.id');
// dd($poste_id);
        $historiqueposteUser = new Historique();
        $historiqueposteUser->type = 'posteUser';
        $historiqueposteUser->valeur = $poste_id[0];
        $historiqueposteUser->cle = $horaireagent->user_id;
        $historiqueposteUser->save();


    }

    private static function updateUserPostes($user)
    {
        // Récupérer les IDs des postes associés à l'utilisateur
        $postIds = DB::table('horaireagents')
            ->join('horaires', 'horaireagents.horaire_id', '=', 'horaires.id')
            ->join('postes', 'horaires.poste_id', '=', 'postes.id')
            ->where('horaireagents.user_id', $user->user_id)
            ->whereNull('horaireagents.deleted_at')
            ->whereNull('horaires.deleted_at')
            ->whereNull('postes.deleted_at')
            ->pluck('postes.id')
            ->unique()
            ->toArray();

        // Convertir les IDs de postes en une chaîne de caractères séparés par des virgules
        $postIdsString = implode(',', $postIds);
// dd($user->user_id,$postIdsString);
        // Mettre à jour le champ postes de l'utilisateur
        DB::table('users')
            ->where('id', $user->user_id)
            ->update(['postes' => $postIdsString]);
    }

    /**
     * Handle the Horaires "updated" event.
     *
     * @param Horaireagent $horaireagent
     * @return void
     */
    public static function updated(Horaireagent $horaireagent)
    {


    }

    /**
     * Handle the Horaires "deleted" event.
     *
     * @param Horaireagent $horaireagent
     * @return void
     */
    public static function deleted(Horaireagent $horaireagent)
    {

        self::updateUserPostes($horaireagent);
    }

    /**
     * Handle the Horaires "restored" event.
     *
     * @param Horaireagent $horaireagent
     * @return void
     */
    public static function restored(Horaireagent $horaireagent)
    {
        //
    }

    /**
     * Handle the Horaires "force deleted" event.
     *
     * @param Horaireagent $horaireagent
     * @return void
     */
    public static function forceDeleted(Horaireagent $horaireagent)
    {
        //


    }
}
