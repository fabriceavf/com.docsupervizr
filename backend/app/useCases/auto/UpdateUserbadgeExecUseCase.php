<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateUserbadgeExecUseCase
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

        $Userbadges = \App\Models\Userbadge::find($data['id']);
        $oldUserbadges = $Userbadges->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldUserbadges->user_id;
        $oldCrudData['num_badge'] = $oldUserbadges->num_badge;
        $oldCrudData['identifiants_sadge'] = $oldUserbadges->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldUserbadges->creat_by;
        try {
            $oldCrudData['user'] = $oldUserbadges->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Userbadges->user_id = $data['user_id'];
        }
        if (!empty($data['num_badge'])) {
            $Userbadges->num_badge = $data['num_badge'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Userbadges->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Userbadges->creat_by = $data['creat_by'];
        }
        $Userbadges->save();
        $Userbadges = \App\Models\Userbadge::find($Userbadges->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Userbadges->user_id;
        $newCrudData['num_badge'] = $Userbadges->num_badge;
        $newCrudData['identifiants_sadge'] = $Userbadges->identifiants_sadge;
        $newCrudData['creat_by'] = $Userbadges->creat_by;
        try {
            $newCrudData['user'] = $Userbadges->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Userbadges', 'entite_cle' => $Userbadges->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Userbadges->toArray();
        return $data;
    }

}
