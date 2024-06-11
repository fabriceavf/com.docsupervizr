<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDocumentExecUseCase
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

        $Documents = \App\Models\Document::find($data['id']);
        $oldDocuments = $Documents->replicate();

        $oldCrudData = [];
        $oldCrudData['nom'] = $oldDocuments->nom;
        $oldCrudData['rubrique'] = $oldDocuments->rubrique;
        $oldCrudData['fichier'] = $oldDocuments->fichier;
        $oldCrudData['agent_id'] = $oldDocuments->agent_id;
        $oldCrudData['identifiants_sadge'] = $oldDocuments->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldDocuments->creat_by;


        if (!empty($data['nom'])) {
            $Documents->nom = $data['nom'];
        }
        if (!empty($data['rubrique'])) {
            $Documents->rubrique = $data['rubrique'];
        }
        if (!empty($data['fichier'])) {
            $Documents->fichier = $data['fichier'];
        }
        if (!empty($data['agent_id'])) {
            $Documents->agent_id = $data['agent_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Documents->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Documents->creat_by = $data['creat_by'];
        }
        $Documents->save();
        $Documents = \App\Models\Document::find($Documents->id);
        $newCrudData = [];
        $newCrudData['nom'] = $Documents->nom;
        $newCrudData['rubrique'] = $Documents->rubrique;
        $newCrudData['fichier'] = $Documents->fichier;
        $newCrudData['agent_id'] = $Documents->agent_id;
        $newCrudData['identifiants_sadge'] = $Documents->identifiants_sadge;
        $newCrudData['creat_by'] = $Documents->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Documents', 'entite_cle' => $Documents->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Documents->toArray();
        return $data;
    }

}
