<?php

namespace App\Observers;

use App\Http\Pointages;
use App\Models\Historique;
use App\Models\Modelslisting;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;


class ModelslistingObservers
{
    /**
     * Handle the Modelslistings "created" event.
     *
     * @param Modelslisting $Modelslisting
     * @return void
     */
    public static function created(Modelslisting $Modelslisting)
    {
        if ($Modelslisting->postes) {
            $postes = explode(",", $Modelslisting->postes);
            foreach ($postes as $poste) {
                $historiqueposteModelslisting = new Historique();
                $historiqueposteModelslisting->type = 'posteModelslisting';
                $historiqueposteModelslisting->valeur = $poste;
                $historiqueposteModelslisting->cle = $Modelslisting->id;
                $historiqueposteModelslisting->save();
            }

        }
        $Modelslisting->etats = 1;
        $Modelslisting->saveQuietly();
        Bus::chain([
            function () {
                Pointages::genereListing();
            }
        ])->dispatch();


    }

    /**
     * Handle the Modelslistings "updated" event.
     *
     * @param Modelslisting $Modelslisting
     * @return void
     */
    public static function updated(Modelslisting $Modelslisting)
    {

        if ($Modelslisting->isDirty('postes')) {
            $postes = explode(",", $Modelslisting->postes);
            // dd($postes);
            DB::table('historiques')->where('type', 'posteModelslisting')->where('cle', $Modelslisting->id)->whereIn('valeur', $postes)->delete();

            foreach ($postes as $poste) {
                $historiqueposteModelslisting = new Historique();
                $historiqueposteModelslisting->type = 'posteModelslisting';
                $historiqueposteModelslisting->valeur = $poste;
                $historiqueposteModelslisting->cle = $Modelslisting->id;
                $historiqueposteModelslisting->save();
            }

        }
        Bus::chain([
            function () {
                Pointages::genereListing();
            }
        ])->dispatch();

    }

    /**
     * Handle the Modelslistings "deleted" event.
     *
     * @param Modelslisting $Modelslisting
     * @return void
     */
    public static function deleted(Modelslisting $Modelslisting)
    {

    }

    /**
     * Handle the Modelslistings "restored" event.
     *
     * @param Modelslisting $Modelslisting
     * @return void
     */
    public static function restored(Modelslisting $Modelslisting)
    {
//
    }

    /**
     * Handle the Modelslistings "force deleted" event.
     *
     * @param Modelslisting $Modelslisting
     * @return void
     */
    public static function forceDeleted(Modelslisting $Modelslisting)
    {


    }
}
