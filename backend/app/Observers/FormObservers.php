<?php

namespace App\Observers;

use App\Models\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class FormObservers
{
    /**
     * Handle the Forms "created" event.
     *
     * @param Form $form
     * @return void
     */
    public static function created(Form $form)
    {


        $existKey = [];
        $lastKey = 0;
        $champs = explode(',', $form->champs);
        $AllChamps = DB::table('formschamps')->whereIn('id', $champs)->get()->toArray();

        foreach ($AllChamps as $champs) {
            if (Str::is('cle*', $champs->cle)) {
                $existKey[] = Str::replace('cle', '', $champs->cle);
            }
        }
        if (count($existKey) > 0) {
            $lastKey = max($existKey);
        }
        foreach ($AllChamps as $champ) {
            if (!Str::is('cle*', $champ->cle)) {
                $lastKey++;
                DB::table('formschamps')->where('id', $champ->id)->update(['cle' => 'cle' . $lastKey]);
            }
        }

    }

    /**
     * Handle the Forms "updated" event.
     *
     * @param Form $form
     * @return void
     */
    public static function updated(Form $form)
    {
        $childs = collect(explode(',', $form->childs))->filter(function ($data) use ($form) {
            return $data != $form->id;
        })->toArray();
        $form->childs = implode(',', $childs);
        $form->saveQuietly();

        $existKey = [];
        $lastKey = 0;
        $champs = explode(',', $form->champs);
        $AllChamps = DB::table('formschamps')->whereIn('id', $champs)->get()->toArray();

        foreach ($AllChamps as $champs) {
            if (Str::is('cle*', $champs->cle)) {
                $existKey[] = Str::replace('cle', '', $champs->cle);
            }
        }
        if (count($existKey) > 0) {
            $lastKey = max($existKey);
        }
        foreach ($AllChamps as $champ) {
            if (!Str::is('cle*', $champ->cle)) {
                $lastKey++;
                DB::table('formschamps')->where('id', $champ->id)->update(['cle' => 'cle' . $lastKey]);
            }
        }


    }

    /**
     * Handle the Forms "deleted" event.
     *
     * @param Form $form
     * @return void
     */
    public static function deleted(Form $form)
    {


    }

    /**
     * Handle the Forms "restored" event.
     *
     * @param Form $form
     * @return void
     */
    public static function restored(Form $form)
    {
//
    }

    /**
     * Handle the Forms "force deleted" event.
     *
     * @param Form $form
     * @return void
     */
    public static function forceDeleted(Form $form)
    {
//


    }
}
