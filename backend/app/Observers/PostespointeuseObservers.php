<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Postespointeuse;

class PostespointeuseObservers
{
    /**
     * Handle the Postespointeuse "created" event.
     *
     * @param Postespointeuse $postespointeuse
     * @return void
     */
    public function created(Postespointeuse $postespointeuse)
    {
        $historiqueposteUser = new Historique();
        $historiqueposteUser->type = 'postePointeuse';
        $historiqueposteUser->valeur = $postespointeuse->poste_id;
        $historiqueposteUser->cle = $postespointeuse->pointeuse_id;
        $historiqueposteUser->save();
    }

    /**
     * Handle the Postespointeuse "updated" event.
     *
     * @param Postespointeuse $postespointeuse
     * @return void
     */
    public function updated(Postespointeuse $postespointeuse)
    {
        $historiqueposteUser = new Historique();
        $historiqueposteUser->type = 'postePointeuse';
        $historiqueposteUser->valeur = $postespointeuse->poste_id;
        $historiqueposteUser->cle = $postespointeuse->pointeuse_id;
        $historiqueposteUser->save();
    }

    /**
     * Handle the Postespointeuse "deleted" event.
     *
     * @param Postespointeuse $postespointeuse
     * @return void
     */
    public function deleted(Postespointeuse $postespointeuse)
    {
        //
    }

    /**
     * Handle the Postespointeuse "restored" event.
     *
     * @param Postespointeuse $postespointeuse
     * @return void
     */
    public function restored(Postespointeuse $postespointeuse)
    {
        //
    }

    /**
     * Handle the Postespointeuse "force deleted" event.
     *
     * @param Postespointeuse $postespointeuse
     * @return void
     */
    public function forceDeleted(Postespointeuse $postespointeuse)
    {
        //
    }
}
