<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Pointeuse;
use Illuminate\Support\Facades\DB;
use Throwable;


class PointeuseObservers
{
    /**
     * Handle the Pointeuses "created" event.
     *
     * @param Pointeuse $pointeuse
     * @return void
     */
    public static function created(Pointeuse $pointeuse)
    {
    }

    /**
     * Handle the Pointeuses "updated" event.
     *
     * @param Pointeuse $pointeuse
     * @return void
     */
    public static function updated(Pointeuse $pointeuse)
    {
        $extra = [];
        try {
            $extra = $pointeuse->extra_attributes['extra-data'];
        } catch (Throwable $e) {
        }
        $postes = [];
        try {
            $postes = collect(explode(',', $extra['allPostes']))->filter(function ($data) {
                return !empty($data);
            })->toArray();
        } catch (Throwable $e) {
        }

        $taches = [];
        try {
            $taches = collect(explode(',', $extra['alltaches']))->filter(function ($data) {
                return !empty($data);
            })->toArray();
        } catch (Throwable $e) {
        }


        // Begin the transaction
        DB::beginTransaction();

        try {
            DB::table('postespointeuses')->where('pointeuse_id', $pointeuse->id)->delete();

            DB::table('historiques')->where('type', 'postePointeuse')->where('cle', $pointeuse->id)->whereIn('valeur', $postes)->delete();
            foreach ($postes as $poste) {
                DB::table('postespointeuses')->insert([
                    'poste_id' => $poste,
                    'pointeuse_id' => $pointeuse->id,
                ]);

                $historiqueposteUser = new Historique();
                $historiqueposteUser->type = 'postePointeuse';
                $historiqueposteUser->valeur = $poste;
                $historiqueposteUser->cle = $pointeuse->id;
                $historiqueposteUser->save();
            }

            DB::table('historiques')->where('type', 'tachePointeuse')->where('cle', $pointeuse->id)->whereIn('valeur', $taches)->delete();
            foreach ($taches as $tache) {
                DB::table('tachespointeuses')->insert([
                    'tache_id' => $tache,
                    'pointeuse_id' => $pointeuse->id,
                ]);

                $historiqueposteUser = new Historique();
                $historiqueposteUser->type = 'tachePointeuse';
                $historiqueposteUser->valeur = $tache;
                $historiqueposteUser->cle = $pointeuse->id;
                $historiqueposteUser->save();
            }

            // Commit the transaction if everything is successful
            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            // Rollback the transaction on error
            DB::rollback();
            // Handle the error as needed
        }


    }

    /**
     * Handle the Pointeuses "deleted" event.
     *
     * @param Pointeuse $pointeuse
     * @return void
     */
    public static function deleted(Pointeuse $pointeuse)
    {
    }

    /**
     * Handle the Pointeuses "restored" event.
     *
     * @param Pointeuse $pointeuse
     * @return void
     */
    public static function restored(Pointeuse $pointeuse)
    {
        //
    }

    /**
     * Handle the Pointeuses "force deleted" event.
     *
     * @param Pointeuse $pointeuse
     * @return void
     */
    public static function forceDeleted(Pointeuse $pointeuse)
    {
        //


    }
}
