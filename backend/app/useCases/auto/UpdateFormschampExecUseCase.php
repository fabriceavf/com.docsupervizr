<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateFormschampExecUseCase
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

        $Formschamps = \App\Models\Formschamp::find($data['id']);
        $oldFormschamps = $Formschamps->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldFormschamps->libelle;
        $oldCrudData['description'] = $oldFormschamps->description;
        $oldCrudData['type'] = $oldFormschamps->type;
        $oldCrudData['cle'] = $oldFormschamps->cle;
        $oldCrudData['width'] = $oldFormschamps->width;
        $oldCrudData['creat_by'] = $oldFormschamps->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldFormschamps->identifiants_sadge;


        if (!empty($data['libelle'])) {
            $Formschamps->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Formschamps->description = $data['description'];
        }
        if (!empty($data['type'])) {
            $Formschamps->type = $data['type'];
        }
        if (!empty($data['cle'])) {
            $Formschamps->cle = $data['cle'];
        }
        if (!empty($data['width'])) {
            $Formschamps->width = $data['width'];
        }
        if (!empty($data['creat_by'])) {
            $Formschamps->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Formschamps->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Formschamps->save();
        $Formschamps = \App\Models\Formschamp::find($Formschamps->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Formschamps->libelle;
        $newCrudData['description'] = $Formschamps->description;
        $newCrudData['type'] = $Formschamps->type;
        $newCrudData['cle'] = $Formschamps->cle;
        $newCrudData['width'] = $Formschamps->width;
        $newCrudData['creat_by'] = $Formschamps->creat_by;
        $newCrudData['identifiants_sadge'] = $Formschamps->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Formschamps', 'entite_cle' => $Formschamps->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Formschamps->toArray();
        return $data;
    }

}
