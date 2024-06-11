<?php

namespace App\Observers;

use App\Models\Poste;
use Illuminate\Support\Facades\DB;


class PosteObservers
{
    /**
     * Handle the Postes "created" event.
     *
     * @param Poste $poste
     * @return void
     */
    public static function created(Poste $poste)
    {
        // Utils::createDefaultHorairesInPoste($poste);
        $horairestypespostes = DB::table('horairestypespostes')
            ->where('typesposte_id', $poste->typesposte_id)->get();
        foreach ($horairestypespostes as $horairestypesposte) {
            DB::table('horaires')
                ->updateOrInsert([
                    'libelle' => $horairestypesposte->libelle,
                    'type' => $horairestypesposte->libelle,
                    'debut' => $horairestypesposte->debut,
                    'fin' => $horairestypesposte->fin,
                    'poste_id' => $poste->id,
                ]);
        }
    }

    /**
     * Handle the Postes "updated" event.
     *
     * @param Poste $poste
     * @return void
     */
    public static function updated(Poste $poste)
    {
        // Utils::createDefaultHorairesInPoste($poste);

        $horairestypespostes = DB::table('horairestypespostes')
            ->where('typesposte_id', $poste->typesposte_id)->get();
        foreach ($horairestypespostes as $horairestypesposte) {
            DB::table('horaires')
                ->updateOrInsert([
                    'libelle' => $horairestypesposte->libelle,
                    'type' => $horairestypesposte->libelle,
                    'debut' => $horairestypesposte->debut,
                    'fin' => $horairestypesposte->fin,
                    'poste_id' => $poste->id,
                ]);
        }

    }

    /**
     * Handle the Postes "deleted" event.
     *
     * @param Poste $poste
     * @return void
     */
    public static function deleted(Poste $poste)
    {


    }

    /**
     * Handle the Postes "restored" event.
     *
     * @param Poste $poste
     * @return void
     */
    public static function restored(Poste $poste)
    {
//
    }

    /**
     * Handle the Postes "force deleted" event.
     *
     * @param Poste $poste
     * @return void
     */
    public static function forceDeleted(Poste $poste)
    {
//


    }
}
