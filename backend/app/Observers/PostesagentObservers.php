<?php

namespace App\Observers;

use App\Models\Postesagent;
use App\Models\User;


class PostesagentObservers
{
    /**
     * Handle the Postesagentss "created" event.
     *
     * @param Postesagent $Postesagent
     * @return void
     */
    public static function created(Postesagent $Postesagent)
    {
        $userId = $Postesagent->user_id;
        $poste = $Postesagent->poste_id;
        if (!empty($poste) && !empty($userId)) {
            $user = User::find($userId);
            $user->poste_id = $poste;
            $user->save();
        }


    }

    /**
     * Handle the Postesagentss "updated" event.
     *
     * @param Postesagent $Postesagent
     * @return void
     */
    public static function updated(Postesagent $Postesagent)
    {

        $userId = $Postesagent->user_id;
        $poste = $Postesagent->poste_id;
        if (!empty($poste) && !empty($userId)) {
            $user = User::find($userId);
            $user->poste_id = $poste;
            $user->save();
        }

    }

    /**
     * Handle the Postesagentss "deleted" event.
     *
     * @param Postesagent $Postesagent
     * @return void
     */
    public static function deleted(Postesagent $Postesagent)
    {


    }

    /**
     * Handle the Postesagentss "restored" event.
     *
     * @param Postesagent $Postesagent
     * @return void
     */
    public static function restored(Postesagent $Postesagent)
    {
//
    }

    /**
     * Handle the Postesagentss "force deleted" event.
     *
     * @param Postesagent $Postesagent
     * @return void
     */
    public static function forceDeleted(Postesagent $Postesagent)
    {
//


    }
}
