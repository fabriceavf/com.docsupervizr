<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHistoriquemodelslistingExecUseCase
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
        $oldHistoriquemodelslistings = $Historiquemodelslistings->replicate();

        $oldCrudData = [];
        $oldCrudData['action'] = $oldHistoriquemodelslistings->action;
        $oldCrudData['ancien'] = $oldHistoriquemodelslistings->ancien;
        $oldCrudData['nouveau'] = $oldHistoriquemodelslistings->nouveau;
        $oldCrudData['modelisting_id'] = $oldHistoriquemodelslistings->modelisting_id;
        $oldCrudData['user_id'] = $oldHistoriquemodelslistings->user_id;
        $oldCrudData['identifiants_sadge'] = $oldHistoriquemodelslistings->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldHistoriquemodelslistings->creat_by;
        try {
            $oldCrudData['user'] = $oldHistoriquemodelslistings->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['action'])) {
            $Historiquemodelslistings->action = $data['action'];
        }
        if (!empty($data['ancien'])) {
            $Historiquemodelslistings->ancien = $data['ancien'];
        }
        if (!empty($data['nouveau'])) {
            $Historiquemodelslistings->nouveau = $data['nouveau'];
        }
        if (!empty($data['modelisting_id'])) {
            $Historiquemodelslistings->modelisting_id = $data['modelisting_id'];
        }
        if (!empty($data['user_id'])) {
            $Historiquemodelslistings->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Historiquemodelslistings->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Historiquemodelslistings->creat_by = $data['creat_by'];
        }
        $Historiquemodelslistings->save();
        $Historiquemodelslistings = \App\Models\Historiquemodelslisting::find($Historiquemodelslistings->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Historiquemodelslistings', 'entite_cle' => $Historiquemodelslistings->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Historiquemodelslistings->toArray();
        return $data;
    }

}
