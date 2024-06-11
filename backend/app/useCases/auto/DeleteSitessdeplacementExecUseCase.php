<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSitessdeplacementExecUseCase
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

        $Sitessdeplacements = \App\Models\Sitessdeplacement::find($data['id']);


        $Sitessdeplacements->deleted_at = now();
        $Sitessdeplacements->save();
        $newCrudData = [];
        $newCrudData['deplacement_id'] = $Sitessdeplacements->deplacement_id;
        $newCrudData['site_id'] = $Sitessdeplacements->site_id;
        $newCrudData['durees'] = $Sitessdeplacements->durees;
        $newCrudData['creat_by'] = $Sitessdeplacements->creat_by;
        $newCrudData['date'] = $Sitessdeplacements->date;
        try {
            $newCrudData['deplacement'] = $Sitessdeplacements->deplacement->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Sitessdeplacements->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Sitessdeplacements', 'entite_cle' => $Sitessdeplacements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
