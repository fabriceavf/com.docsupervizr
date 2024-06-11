<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Historique;
use Illuminate\Support\Facades\DB;

class UserObservers
{
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        if ($user->num_badge || $user->emp_code) {
            $historiqueBadgeUser = new Historique();
            $historiqueBadgeUser->type = 'BadgeUser';
            if ($user->num_badge) {
                // $historiqueBadgeUser->valeur = $user->num_badge."(Teleric)";
                $historiqueBadgeUser->valeur = $user->num_badge;
            }
            if ($user->emp_code) {
                // $historiqueBadgeUser->valeur = $user->emp_code."(ZkTeco)";
                $historiqueBadgeUser->valeur = $user->emp_code;
            }
            $historiqueBadgeUser->cle = $user->id;
            $historiqueBadgeUser->save();


            \App\Http\Utils::assignationDeCartes($user, now(), DB::connection(DB::getDefaultConnection()));
        }

        if ($user->poste_id) {
            $historiqueposteUser = new Historique();
            $historiqueposteUser->type = 'posteUser';
            $historiqueposteUser->valeur = $user->poste_id;
            $historiqueposteUser->cle = $user->id;
            $historiqueposteUser->save();
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {

        if ($user->isDirty('num_badge') || $user->isDirty('emp_code')) {
            $historiqueBadgeUser = new Historique();
            $historiqueBadgeUser->type = 'BadgeUser';
            if ($user->isDirty('num_badge')) {
                // $historiqueBadgeUser->valeur = $user->num_badge . "(Teleric)";
                $historiqueBadgeUser->valeur = $user->num_badge;
            }
            if ($user->isDirty('emp_code')) {
                // $historiqueBadgeUser->valeur = $user->emp_code . "(ZkTeco)";
                $historiqueBadgeUser->valeur = $user->emp_code;
            }
            $historiqueBadgeUser->cle = $user->id;
            $historiqueBadgeUser->save();
            \App\Http\Utils::assignationDeCartes($user, now(), DB::connection(DB::getDefaultConnection()));
        }

        if ($user->isDirty('poste_id')) {
            $historiqueposteUser = new Historique();
            $historiqueposteUser->type = 'posteUser';
            $historiqueposteUser->valeur = $user->poste_id;
            $historiqueposteUser->cle = $user->id;
            $historiqueposteUser->save();

        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }


}
