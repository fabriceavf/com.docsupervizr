<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteActiviteExecUseCase
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

        $Activites = \App\Models\Activite::find($data['id']);


        $Activites->deleted_at = now();
        $Activites->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Activites->libelle;
        $newCrudData['duree'] = $Activites->duree;
        $newCrudData['parent'] = $Activites->parent;
        $newCrudData['user_id'] = $Activites->user_id;
        $newCrudData['has_child'] = $Activites->has_child;
        $newCrudData['description'] = $Activites->description;
        $newCrudData['validate'] = $Activites->validate;
        $newCrudData['type'] = $Activites->type;
        $newCrudData['etats_actuel'] = $Activites->etats_actuel;
        $newCrudData['description_actuel'] = $Activites->description_actuel;
        $newCrudData['ParentElements'] = $Activites->ParentElements;
        $newCrudData['AllEtats'] = $Activites->AllEtats;
        $newCrudData['CanUpdate'] = $Activites->CanUpdate;
        $newCrudData['IsCreateByMe'] = $Activites->IsCreateByMe;
        $newCrudData['IsWorkForMe'] = $Activites->IsWorkForMe;
        $newCrudData['Status'] = $Activites->Status;
        $newCrudData['Createur'] = $Activites->Createur;
        $newCrudData['identifiants_sadge'] = $Activites->identifiants_sadge;
        $newCrudData['creat_by'] = $Activites->creat_by;
        try {
            $newCrudData['user'] = $Activites->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Activites', 'entite_cle' => $Activites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
