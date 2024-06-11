<?php

namespace App\Observers;

use App\Http\Utils;
use App\Models\Import;
use Illuminate\Support\Facades\Bus;


class ImportObservers
{
    /**
     * Handle the Imports "created" event.
     *
     * @param Import $import
     * @return void
     */
    public static function created(Import $import)
    {


    }

    /**
     * Handle the Imports "updated" event.
     *
     * @param Import $import
     * @return void
     */
    public static function updated(Import $import)
    {
        Bus::chain([
            function () {
                Utils::runImportations();
            }
        ])->dispatch();

    }

    /**
     * Handle the Imports "deleted" event.
     *
     * @param Import $import
     * @return void
     */
    public static function deleted(Import $import)
    {


    }

    /**
     * Handle the Imports "restored" event.
     *
     * @param Import $import
     * @return void
     */
    public static function restored(Import $import)
    {
//
    }

    /**
     * Handle the Imports "force deleted" event.
     *
     * @param Import $import
     * @return void
     */
    public static function forceDeleted(Import $import)
    {
//


    }
}
