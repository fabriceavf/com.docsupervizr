<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHistoriqueExecUseCase
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

        $Historiques = \App\Models\Historique::find($data['id']);
        $oldHistoriques = $Historiques->replicate();

        $oldCrudData = [];
        $oldCrudData['type'] = $oldHistoriques->type;
        $oldCrudData['cle'] = $oldHistoriques->cle;
        $oldCrudData['valeur'] = $oldHistoriques->valeur;
        $oldCrudData['identifiants_sadge'] = $oldHistoriques->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldHistoriques->creat_by;


        if (!empty($data['type'])) {
            $Historiques->type = $data['type'];
        }
        if (!empty($data['cle'])) {
            $Historiques->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Historiques->valeur = $data['valeur'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Historiques->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Historiques->creat_by = $data['creat_by'];
        }
        $Historiques->save();
        $Historiques = \App\Models\Historique::find($Historiques->id);
        $newCrudData = [];
        $newCrudData['type'] = $Historiques->type;
        $newCrudData['cle'] = $Historiques->cle;
        $newCrudData['valeur'] = $Historiques->valeur;
        $newCrudData['identifiants_sadge'] = $Historiques->identifiants_sadge;
        $newCrudData['creat_by'] = $Historiques->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Historiques', 'entite_cle' => $Historiques->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Historiques->toArray();
        return $data;
    }

}
