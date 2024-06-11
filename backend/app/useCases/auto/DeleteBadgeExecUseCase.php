<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteBadgeExecUseCase
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

        $Badges = \App\Models\Badge::find($data['id']);


        $Badges->deleted_at = now();
        $Badges->save();
        $newCrudData = [];
        $newCrudData['client_id'] = $Badges->client_id;
        $newCrudData['content'] = $Badges->content;
        $newCrudData['js'] = $Badges->js;
        $newCrudData['libelle'] = $Badges->libelle;
        $newCrudData['css'] = $Badges->css;
        $newCrudData['node_version'] = $Badges->node_version;
        $newCrudData['identifiants_sadge'] = $Badges->identifiants_sadge;
        $newCrudData['creat_by'] = $Badges->creat_by;
        try {
            $newCrudData['client'] = $Badges->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Badges', 'entite_cle' => $Badges->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
