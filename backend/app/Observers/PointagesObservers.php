<?php

namespace App\Observers;

use App\Models\Pointage;
use Carbon\Carbon;


class PointagesObservers
{
    /**
     * Handle the Pointages "created" event.
     *
     * @param Pointage $pointage
     * @return void
     */
    public static function created(Pointage $pointage)
    {

        if (!empty($pointage->debut_realise) && !empty($pointage->fin_realise)) {

            $debut = clone(Carbon::parse($pointage->debut_realise));
            $fin = clone(Carbon::parse($pointage->fin_realise));
            $horaire2_interval = $fin->diff($debut);
            $volume_prevu2 = $horaire2_interval->format('%h');
            $pointage->volume_realise = $volume_prevu2;

            $pointage->est_attendu = 0;

            $pointage->volume_realise = $horaire2_interval->format('%h h %i m');
            $pointage->saveQuietly();

        }


    }

    /**
     * Handle the Pointages "updated" event.
     *
     * @param Pointage $pointage
     * @return void
     */
    public static function updated(Pointage $pointage)
    {

        if (!empty($pointage->debut_realise) && !empty($pointage->fin_realise)) {

            $debut = clone(Carbon::parse($pointage->debut_realise));
            $fin = clone(Carbon::parse($pointage->fin_realise));
            $horaire2_interval = $fin->diff($debut);
            $volume_prevu2 = $horaire2_interval->format('%h');
            $pointage->volume_realise = $volume_prevu2;
            $pointage->est_attendu = 0;

            $pointage->volume_realise = $horaire2_interval->format('%h h %i m');
            $pointage->saveQuietly();

        }


    }

    /**
     * Handle the Pointages "deleted" event.
     *
     * @param Pointage $pointage
     * @return void
     */
    public static function deleted(Pointage $pointage)
    {


    }

    /**
     * Handle the Pointages "restored" event.
     *
     * @param Pointage $pointage
     * @return void
     */
    public static function restored(Pointage $pointage)
    {
//
    }

    /**
     * Handle the Pointages "force deleted" event.
     *
     * @param Pointage $pointage
     * @return void
     */
    public static function forceDeleted(Pointage $pointage)
    {
//


    }
}
