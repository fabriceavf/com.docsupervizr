<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePostesagentExecUseCase
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

        $Postesagents = new \App\Models\Postesagent();

        if (!empty($data['poste_id'])) {
            $Postesagents->poste_id = $data['poste_id'];
        }
        if (!empty($data['user_id'])) {
            $Postesagents->user_id = $data['user_id'];
        }
        if (!empty($data['faction'])) {
            $Postesagents->faction = $data['faction'];
        }
        if (!empty($data['lun'])) {
            $Postesagents->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Postesagents->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Postesagents->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Postesagents->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Postesagents->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Postesagents->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Postesagents->dim = $data['dim'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Postesagents->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Postesagents->creat_by = $data['creat_by'];
        }
        $Postesagents->save();
        $Postesagents = \App\Models\Postesagent::find($Postesagents->id);
        $newCrudData = [];
        $newCrudData['poste_id'] = $Postesagents->poste_id;
        $newCrudData['user_id'] = $Postesagents->user_id;
        $newCrudData['faction'] = $Postesagents->faction;
        $newCrudData['lun'] = $Postesagents->lun;
        $newCrudData['mar'] = $Postesagents->mar;
        $newCrudData['mer'] = $Postesagents->mer;
        $newCrudData['jeu'] = $Postesagents->jeu;
        $newCrudData['ven'] = $Postesagents->ven;
        $newCrudData['sam'] = $Postesagents->sam;
        $newCrudData['dim'] = $Postesagents->dim;
        $newCrudData['identifiants_sadge'] = $Postesagents->identifiants_sadge;
        $newCrudData['creat_by'] = $Postesagents->creat_by;
        try {
            $newCrudData['poste'] = $Postesagents->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Postesagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Postesagents', 'entite_cle' => $Postesagents->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postesagents->toArray();
        return $data;
    }

}
