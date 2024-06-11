<?php

namespace App\Observers;

use App\Models\CrudsModel;
use App\Models\Historique;
use App\Models\Programmation;
use App\Models\ValidationsModel;
use App\Validations\ProgrammationsValidation;


class ProgrammationObservers
{
    /**
     * Handle the Programmations "created" event.
     *
     * @param Programmation $programmation
     * @return void
     */
    public static function created(Programmation $programmation)
    {
        $mot = 'listings-du-model-';
        if (stristr($programmation->type, $mot)) {
            $mots = explode('listings-du-model-', $programmation->type);
            $mots = $mots[1];
            $historiquelisting = new Historique();
            $historiquelisting->type = 'listings';
            $historiquelisting->valeur = 'creation du listings ' . $programmation->libelle . ' du ' . $programmation->date_debut;
            $historiquelisting->cle = $mots;
            $historiquelisting->save();
        }

        self::traitementData($programmation);
    }

    private static function traitementData(Programmation $programmation)
    {

    }

    /**
     * Handle the Programmations "updated" event.
     *
     * @param Programmation $programmation
     * @return void
     */
    public static function updated(Programmation $programmation)
    {
        self::traitementData($programmation);

    }

    /**
     * Handle the Programmations "deleted" event.
     *
     * @param Programmation $programmation
     * @return void
     */
    public static function deleted(Programmation $programmation)
    {
    }

    /**
     * Handle the Programmations "restored" event.
     *
     * @param Programmation $programmation
     * @return void
     */
    public static function restored(Programmation $programmation)
    {
    }

    /**
     * Handle the Programmations "force deleted" event.
     *
     * @param Programmation $programmation
     * @return void
     */
    public static function forceDeleted(Programmation $programmation)
    {
    }
}
