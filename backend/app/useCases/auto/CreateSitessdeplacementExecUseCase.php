<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSitessdeplacementExecUseCase
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

        $Sitessdeplacements = new \App\Models\Sitessdeplacement();

        if (!empty($data['deplacement_id'])) {
            $Sitessdeplacements->deplacement_id = $data['deplacement_id'];
        }
        if (!empty($data['site_id'])) {
            $Sitessdeplacements->site_id = $data['site_id'];
        }
        if (!empty($data['durees'])) {
            $Sitessdeplacements->durees = $data['durees'];
        }
        if (!empty($data['creat_by'])) {
            $Sitessdeplacements->creat_by = $data['creat_by'];
        }
        if (!empty($data['date'])) {
            $Sitessdeplacements->date = $data['date'];
        }
        $Sitessdeplacements->save();
        $Sitessdeplacements = \App\Models\Sitessdeplacement::find($Sitessdeplacements->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Sitessdeplacements', 'entite_cle' => $Sitessdeplacements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Sitessdeplacements->toArray();
        return $data;
    }

}
