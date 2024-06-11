<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateEmpreinteExecUseCase
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

        $Empreintes = \App\Models\Empreinte::find($data['id']);
        $oldEmpreintes = $Empreintes->replicate();

        $oldCrudData = [];
        $oldCrudData['signature'] = $oldEmpreintes->signature;
        $oldCrudData['user_id'] = $oldEmpreintes->user_id;
        $oldCrudData['identifiants_sadge'] = $oldEmpreintes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldEmpreintes->creat_by;
        try {
            $oldCrudData['user'] = $oldEmpreintes->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['signature'])) {
            $Empreintes->signature = $data['signature'];
        }
        if (!empty($data['user_id'])) {
            $Empreintes->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Empreintes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Empreintes->creat_by = $data['creat_by'];
        }
        $Empreintes->save();
        $Empreintes = \App\Models\Empreinte::find($Empreintes->id);
        $newCrudData = [];
        $newCrudData['signature'] = $Empreintes->signature;
        $newCrudData['user_id'] = $Empreintes->user_id;
        $newCrudData['identifiants_sadge'] = $Empreintes->identifiants_sadge;
        $newCrudData['creat_by'] = $Empreintes->creat_by;
        try {
            $newCrudData['user'] = $Empreintes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Empreintes', 'entite_cle' => $Empreintes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Empreintes->toArray();
        return $data;
    }

}
