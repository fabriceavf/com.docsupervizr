<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateActiviteExecUseCase
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
        $oldActivites = $Activites->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldActivites->libelle;
        $oldCrudData['duree'] = $oldActivites->duree;
        $oldCrudData['parent'] = $oldActivites->parent;
        $oldCrudData['user_id'] = $oldActivites->user_id;
        $oldCrudData['has_child'] = $oldActivites->has_child;
        $oldCrudData['description'] = $oldActivites->description;
        $oldCrudData['validate'] = $oldActivites->validate;
        $oldCrudData['type'] = $oldActivites->type;
        $oldCrudData['etats_actuel'] = $oldActivites->etats_actuel;
        $oldCrudData['description_actuel'] = $oldActivites->description_actuel;
        $oldCrudData['ParentElements'] = $oldActivites->ParentElements;
        $oldCrudData['AllEtats'] = $oldActivites->AllEtats;
        $oldCrudData['CanUpdate'] = $oldActivites->CanUpdate;
        $oldCrudData['IsCreateByMe'] = $oldActivites->IsCreateByMe;
        $oldCrudData['IsWorkForMe'] = $oldActivites->IsWorkForMe;
        $oldCrudData['Status'] = $oldActivites->Status;
        $oldCrudData['Createur'] = $oldActivites->Createur;
        $oldCrudData['identifiants_sadge'] = $oldActivites->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldActivites->creat_by;
        try {
            $oldCrudData['user'] = $oldActivites->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Activites->libelle = $data['libelle'];
        }
        if (!empty($data['duree'])) {
            $Activites->duree = $data['duree'];
        }
        if (!empty($data['parent'])) {
            $Activites->parent = $data['parent'];
        }
        if (!empty($data['user_id'])) {
            $Activites->user_id = $data['user_id'];
        }
        if (!empty($data['has_child'])) {
            $Activites->has_child = $data['has_child'];
        }
        if (!empty($data['description'])) {
            $Activites->description = $data['description'];
        }
        if (!empty($data['validate'])) {
            $Activites->validate = $data['validate'];
        }
        if (!empty($data['type'])) {
            $Activites->type = $data['type'];
        }
        if (!empty($data['etats_actuel'])) {
            $Activites->etats_actuel = $data['etats_actuel'];
        }
        if (!empty($data['description_actuel'])) {
            $Activites->description_actuel = $data['description_actuel'];
        }
        if (!empty($data['ParentElements'])) {
            $Activites->ParentElements = $data['ParentElements'];
        }
        if (!empty($data['AllEtats'])) {
            $Activites->AllEtats = $data['AllEtats'];
        }
        if (!empty($data['CanUpdate'])) {
            $Activites->CanUpdate = $data['CanUpdate'];
        }
        if (!empty($data['IsCreateByMe'])) {
            $Activites->IsCreateByMe = $data['IsCreateByMe'];
        }
        if (!empty($data['IsWorkForMe'])) {
            $Activites->IsWorkForMe = $data['IsWorkForMe'];
        }
        if (!empty($data['Status'])) {
            $Activites->Status = $data['Status'];
        }
        if (!empty($data['Createur'])) {
            $Activites->Createur = $data['Createur'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Activites->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Activites->creat_by = $data['creat_by'];
        }
        $Activites->save();
        $Activites = \App\Models\Activite::find($Activites->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Activites', 'entite_cle' => $Activites->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Activites->toArray();
        return $data;
    }

}
