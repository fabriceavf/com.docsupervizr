<?php

namespace App\Observers;

use App\Models\Pastille;
use Illuminate\Support\Facades\DB;


class PastilleObservers
{
    /**
     * Handle the Pastilles "created" event.
     *
     * @param Pastille $pastille
     * @return void
     */
    public static function created(Pastille $pastille)
    {
        self::createPastille($pastille);
    }

    public static function createPastille(Pastille $pastille)
    {
        DB::table('users')
            ->updateOrInsert([
                'num_badge' => $pastille->code,
                'type_id' => '5',
            ], [
                'nom' => $pastille->libelle,
                'prenom' => $pastille->libelle,
                'matricule' => 'Pastille-' . $pastille->code,
            ]);
    }

    /**
     * Handle the Pastilles "updated" event.
     *
     * @param Pastille $pastille
     * @return void
     */
    public static function updated(Pastille $pastille)
    {
        self::createPastille($pastille);
    }

    /**
     * Handle the Pastilles "deleted" event.
     *
     * @param Pastille $pastille
     * @return void
     */
    public static function deleted(Pastille $pastille)
    {


    }

    /**
     * Handle the Pastilles "restored" event.
     *
     * @param Pastille $pastille
     * @return void
     */
    public static function restored(Pastille $pastille)
    {
//
    }

    /**
     * Handle the Pastilles "force deleted" event.
     *
     * @param Pastille $pastille
     * @return void
     */
    public static function forceDeleted(Pastille $pastille)
    {
//


    }
}
