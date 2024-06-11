<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateBadgeExecUseCase
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
        $oldBadges = $Badges->replicate();

        $oldCrudData = [];
        $oldCrudData['client_id'] = $oldBadges->client_id;
        $oldCrudData['content'] = $oldBadges->content;
        $oldCrudData['js'] = $oldBadges->js;
        $oldCrudData['libelle'] = $oldBadges->libelle;
        $oldCrudData['css'] = $oldBadges->css;
        $oldCrudData['node_version'] = $oldBadges->node_version;
        $oldCrudData['identifiants_sadge'] = $oldBadges->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldBadges->creat_by;
        try {
            $oldCrudData['client'] = $oldBadges->client->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['client_id'])) {
            $Badges->client_id = $data['client_id'];
        }
        if (!empty($data['content'])) {
            $Badges->content = $data['content'];
        }
        if (!empty($data['js'])) {
            $Badges->js = $data['js'];
        }
        if (!empty($data['libelle'])) {
            $Badges->libelle = $data['libelle'];
        }
        if (!empty($data['css'])) {
            $Badges->css = $data['css'];
        }
        if (!empty($data['node_version'])) {
            $Badges->node_version = $data['node_version'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Badges->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Badges->creat_by = $data['creat_by'];
        }
        $Badges->save();
        $Badges = \App\Models\Badge::find($Badges->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Badges', 'entite_cle' => $Badges->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Badges->toArray();
        return $data;
    }

}
