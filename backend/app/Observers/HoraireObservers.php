<?php

namespace App\Observers;

use App\Http\App;
use App\Models\Horaire;


class HoraireObservers
{
    /**
     * Handle the Horaires "created" event.
     *
     * @param Horaire $horaire
     * @return void
     */
    public static function created(Horaire $horaire)
    {

        $deb = intval(explode(':', $horaire->debut)[0]);
        $fin = intval(explode(':', $horaire->fin)[0]);

//        dd($deb,$fin);
        if ($deb >= $fin) {
            $horaire->type = 'Nuit';

        } else {
            $horaire->type = 'Jour';

        }


        App::saveReposHoraires($horaire);
        $horaire->saveQuietly();


    }

    /**
     * Handle the Horaires "updated" event.
     *
     * @param Horaire $horaire
     * @return void
     */
    public static function updated(Horaire $horaire)
    {

        $deb = intval(explode(':', $horaire->debut)[0]);
        $fin = intval(explode(':', $horaire->fin)[0]);

//        dd($deb,$fin);
        if ($deb >= $fin) {
            $horaire->type = 'Nuit';

        } else {
            $horaire->type = 'Jour';

        }
        $horaire->saveQuietly();
        App::saveReposHoraires($horaire);

    }

    /**
     * Handle the Horaires "deleted" event.
     *
     * @param Horaire $horaire
     * @return void
     */
    public static function deleted(Horaire $horaire)
    {

        App::saveReposHoraires($horaire->parentId);


    }

    /**
     * Handle the Horaires "restored" event.
     *
     * @param Horaire $horaire
     * @return void
     */
    public static function restored(Horaire $horaire)
    {
//
    }

    /**
     * Handle the Horaires "force deleted" event.
     *
     * @param Horaire $horaire
     * @return void
     */
    public static function forceDeleted(Horaire $horaire)
    {
//


    }
}
