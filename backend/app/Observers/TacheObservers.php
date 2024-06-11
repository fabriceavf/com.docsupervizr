<?php

namespace App\Observers;

use App\Http\App;
use App\Models\CrudsModel;
use App\Models\Tache;
use App\Models\ValidationsModel;
use App\Validations\TachesValidation;


class TacheObservers
{
    /**
     * Handle the Taches "created" event.
     *
     * @param Tache $tache
     * @return void
     */
    public static function created(Tache $tache)
    {

        App::saveReposHoraires($tache->id);

    }

    /**
     * Handle the Taches "updated" event.
     *
     * @param Tache $tache
     * @return void
     */
    public static function updated(Tache $tache)
    {

        App::saveReposHoraires($tache->id);

    }

    /**
     * Handle the Taches "deleted" event.
     *
     * @param Tache $tache
     * @return void
     */
    public static function deleted(Tache $tache)
    {

        App::saveReposHoraires($tache->id);
    }

    /**
     * Handle the Taches "restored" event.
     *
     * @param Tache $tache
     * @return void
     */
    public static function restored(Tache $tache)
    {
//
    }

    /**
     * Handle the Taches "force deleted" event.
     *
     * @param Tache $tache
     * @return void
     */
    public static function forceDeleted(Tache $tache)
    {


    }
}
