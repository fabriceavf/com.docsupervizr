<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteUserbadgeExecUseCase
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


        $Userbadges->deleted_at = now();
        $Userbadges->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Userbadges->user_id;
        $newCrudData['num_badge'] = $Userbadges->num_badge;
        $newCrudData['identifiants_sadge'] = $Userbadges->identifiants_sadge;
        $newCrudData['creat_by'] = $Userbadges->creat_by;
        try {
            $newCrudData['user'] = $Userbadges->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Userbadges', 'entite_cle' => $Userbadges->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
