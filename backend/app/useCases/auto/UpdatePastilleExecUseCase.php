<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePastilleExecUseCase
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

        $Pastilles = \App\Models\Pastille::find($data['id']);
        $oldPastilles = $Pastilles->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldPastilles->code;
        $oldCrudData['libelle'] = $oldPastilles->libelle;
        $oldCrudData['site_id'] = $oldPastilles->site_id;
        $oldCrudData['creat_by'] = $oldPastilles->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldPastilles->identifiants_sadge;
        try {
            $oldCrudData['site'] = $oldPastilles->site->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['code'])) {
            $Pastilles->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Pastilles->libelle = $data['libelle'];
        }
        if (!empty($data['site_id'])) {
            $Pastilles->site_id = $data['site_id'];
        }
        if (!empty($data['creat_by'])) {
            $Pastilles->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Pastilles->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Pastilles->save();
        $Pastilles = \App\Models\Pastille::find($Pastilles->id);
        $newCrudData = [];
        $newCrudData['code'] = $Pastilles->code;
        $newCrudData['libelle'] = $Pastilles->libelle;
        $newCrudData['site_id'] = $Pastilles->site_id;
        $newCrudData['creat_by'] = $Pastilles->creat_by;
        $newCrudData['identifiants_sadge'] = $Pastilles->identifiants_sadge;
        try {
            $newCrudData['site'] = $Pastilles->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Pastilles', 'entite_cle' => $Pastilles->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Pastilles->toArray();
        return $data;
    }

}
