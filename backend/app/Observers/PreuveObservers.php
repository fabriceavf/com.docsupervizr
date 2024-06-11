<?php

namespace App\Observers;

use App\Http\TransactionsAnalyses;
use App\Models\Preuve;


class PreuveObservers
{
    /**
     * Handle the Preuvess "created" event.
     *
     * @param Preuve $Preuve
     * @return void
     */
    public static function created(Preuve $Preuve)
    {
        TransactionsAnalyses::analysePreuves($Preuve->programme_id);
//        dd('test');
    }

    /**
     * Handle the Preuvess "updated" event.
     *
     * @param Preuve $Preuve
     * @return void
     */
    public static function updated(Preuve $Preuve)
    {

    }

    /**
     * Handle the Preuvess "deleted" event.
     *
     * @param Preuve $Preuve
     * @return void
     */
    public static function deleted(Preuve $Preuve)
    {


    }

    /**
     * Handle the Preuvess "restored" event.
     *
     * @param Preuve $Preuve
     * @return void
     */
    public static function restored(Preuve $Preuve)
    {
//
    }

    /**
     * Handle the Preuvess "force deleted" event.
     *
     * @param Preuve $Preuve
     * @return void
     */
    public static function forceDeleted(Preuve $Preuve)
    {
//


    }
}
