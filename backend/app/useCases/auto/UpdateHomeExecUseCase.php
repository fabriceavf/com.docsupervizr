<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHomeExecUseCase
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

        $Homes = \App\Models\Home::find($data['id']);
        $oldHomes = $Homes->replicate();

        $oldCrudData = [];
        $oldCrudData['user'] = $oldHomes->user;
        $oldCrudData['etat'] = $oldHomes->etat;
        $oldCrudData['creat_by'] = $oldHomes->creat_by;


        if (!empty($data['user'])) {
            $Homes->user = $data['user'];
        }
        if (!empty($data['etat'])) {
            $Homes->etat = $data['etat'];
        }
        if (!empty($data['creat_by'])) {
            $Homes->creat_by = $data['creat_by'];
        }
        $Homes->save();
        $Homes = \App\Models\Home::find($Homes->id);
        $newCrudData = [];
        $newCrudData['user'] = $Homes->user;
        $newCrudData['etat'] = $Homes->etat;
        $newCrudData['creat_by'] = $Homes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Homes', 'entite_cle' => $Homes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Homes->toArray();
        return $data;
    }

}
