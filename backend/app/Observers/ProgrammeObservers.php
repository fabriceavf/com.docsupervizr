<?php

namespace App\Observers;

use App\Models\CrudsModel;
use App\Models\Programme;
use App\Models\ValidationsModel;
use App\Validations\ProgrammesValidation;
use Illuminate\Support\Facades\DB;


class ProgrammeObservers
{
    /**
     * Handle the Programmes "created" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function created(Programme $programme)
    {


        DB::table('transactions')
            ->whereDate('punch_date', '=', $programme->date)
            ->update(['traiter' => 0]);

    }

    /**
     * Handle the Programmes "updated" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function updated(Programme $programme)
    {
        DB::table('transactions')
            ->whereDate('punch_date', '=', $programme->date)
            ->update(['traiter' => 0]);

    }

    /**
     * Handle the Programmes "updated" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function updating(Programme $programme)
    {
        $old = DB::table('programmes')->find($programme->id);
        if ($old->remplacant != $programme->remplacant) {
        }


    }

    /**
     * Handle the Programmes "deleted" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function deleted(Programme $programme)
    {


    }

    /**
     * Handle the Programmes "restored" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function restored(Programme $programme)
    {
//
    }

    /**
     * Handle the Programmes "force deleted" event.
     *
     * @param Programme $programme
     * @return void
     */
    public static function forceDeleted(Programme $programme)
    {


    }
}
