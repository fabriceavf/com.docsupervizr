<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateEtapeExecUseCase
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

        $Etapes = \App\Models\Etape::find($data['id']);
        $oldEtapes = $Etapes->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldEtapes->libelle;
        $oldCrudData['ordre'] = $oldEtapes->ordre;
        $oldCrudData['ligne_id'] = $oldEtapes->ligne_id;
        $oldCrudData['creat_by'] = $oldEtapes->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldEtapes->identifiants_sadge;
        try {
            $oldCrudData['ligne'] = $oldEtapes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Etapes->libelle = $data['libelle'];
        }
        if (!empty($data['ordre'])) {
            $Etapes->ordre = $data['ordre'];
        }
        if (!empty($data['ligne_id'])) {
            $Etapes->ligne_id = $data['ligne_id'];
        }
        if (!empty($data['creat_by'])) {
            $Etapes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Etapes->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Etapes->save();
        $Etapes = \App\Models\Etape::find($Etapes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Etapes->libelle;
        $newCrudData['ordre'] = $Etapes->ordre;
        $newCrudData['ligne_id'] = $Etapes->ligne_id;
        $newCrudData['creat_by'] = $Etapes->creat_by;
        $newCrudData['identifiants_sadge'] = $Etapes->identifiants_sadge;
        try {
            $newCrudData['ligne'] = $Etapes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Etapes', 'entite_cle' => $Etapes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Etapes->toArray();
        return $data;
    }

}
