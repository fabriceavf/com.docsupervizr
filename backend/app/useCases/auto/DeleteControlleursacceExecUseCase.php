<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteControlleursacceExecUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $data['__headers__'] = $request->headers->all();
        $data['__authId__'] = Auth::id();
        $data['__ip__'] = $request->ip();
        $data['creat_by'] = Auth::id();

        $Controlleursacces = \App\Models\Controlleursacce::find($data['id']);


        $Controlleursacces->deleted_at = now();
        $Controlleursacces->save();
        $newCrudData = [];
        $newCrudData['pointeuse_id'] = $Controlleursacces->pointeuse_id;
        $newCrudData['ligne_id'] = $Controlleursacces->ligne_id;
        $newCrudData['deplacement_id'] = $Controlleursacces->deplacement_id;
        $newCrudData['site_id'] = $Controlleursacces->site_id;
        $newCrudData['date_debut'] = $Controlleursacces->date_debut;
        $newCrudData['date_fin'] = $Controlleursacces->date_fin;
        $newCrudData['creat_by'] = $Controlleursacces->creat_by;
        $newCrudData['type'] = $Controlleursacces->type;
        try {
            $newCrudData['deplacement'] = $Controlleursacces->deplacement->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ligne'] = $Controlleursacces->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Controlleursacces->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Controlleursacces->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Controlleursacces', 'entite_cle' => $Controlleursacces->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
