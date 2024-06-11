<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHistoriquemodelslistingExecUseCase
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

        $Historiquemodelslistings = \App\Models\Historiquemodelslisting::find($data['id']);


        $Historiquemodelslistings->deleted_at = now();
        $Historiquemodelslistings->save();
        $newCrudData = [];
        $newCrudData['action'] = $Historiquemodelslistings->action;
        $newCrudData['ancien'] = $Historiquemodelslistings->ancien;
        $newCrudData['nouveau'] = $Historiquemodelslistings->nouveau;
        $newCrudData['modelisting_id'] = $Historiquemodelslistings->modelisting_id;
        $newCrudData['user_id'] = $Historiquemodelslistings->user_id;
        $newCrudData['identifiants_sadge'] = $Historiquemodelslistings->identifiants_sadge;
        $newCrudData['creat_by'] = $Historiquemodelslistings->creat_by;
        try {
            $newCrudData['user'] = $Historiquemodelslistings->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Historiquemodelslistings', 'entite_cle' => $Historiquemodelslistings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
