<?php

namespace App\Observers;

use App\Models\Activite;
use Illuminate\Support\Facades\Auth;


class ActiviteObservers
{
    /**
     * Handle the Activites "created" event.
     *
     * @param Activite $activite
     * @return void
     */
    public static function created(Activite $activite)
    {
        if (empty($activite->user_id)) {
            $activite->user_id = Auth::id();
        }

        if ($activite->type != "normal" && $activite->parent) {
            $parent = Activite::find($activite->parent);

            $actualEtat = explode(',', $parent->etats_actuel ?? "");
            $actualEtat[] = $activite->type;
            $newEtat = implode(',', $actualEtat);
            $parent->etats_actuel = $newEtat;

//            $actualDescription=explode('/++/',$parent->description_actuel);
//            $actualDescription[]=$activite->description;
//            $newDescription=implode(',',$actualDescription);
//            $parent->description_actuel=$newDescription;

            $parent->save();

//            $childs = [];
//            $newChild = DB::table('activites')->where('parent', $parent->id)->pluck('id')->toArray();
//            while (count($newChild) > 0) {
//                $oldChild = $newChild;
//                $childs = array_merge($childs, $oldChild);
//                $newChild = DB::table('activites')->whereIn('parent', $oldChild)->pluck('id')->toArray();
//            }
//            DB::table('activites')->whereIn('id',$newChild)->update([
//               'etats_actuel'=>$activite->type,
//               'description_actuel'=>$activite->description
//            ]);
//            foreach ($childs as $child) {
//                $newData = $activite->replicate();
//                $newData->parent = $child;
//                $newData->saveQuietly();
//            }

        }

        $activite->saveQuietly();


    }

    /**
     * Handle the Activites "updated" event.
     *
     * @param Activite $activite
     * @return void
     */
    public static function updated(Activite $activite)
    {


    }

    /**
     * Handle the Activites "deleted" event.
     *
     * @param Activite $activite
     * @return void
     */
    public static function deleted(Activite $activite)
    {


    }

    /**
     * Handle the Activites "restored" event.
     *
     * @param Activite $activite
     * @return void
     */
    public static function restored(Activite $activite)
    {
//
    }

    /**
     * Handle the Activites "force deleted" event.
     *
     * @param Activite $activite
     * @return void
     */
    public static function forceDeleted(Activite $activite)
    {
//


    }
}
