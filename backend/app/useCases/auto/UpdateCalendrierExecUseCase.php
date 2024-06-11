<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateCalendrierExecUseCase
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

        $Calendriers = \App\Models\Calendrier::find($data['id']);
        $oldCalendriers = $Calendriers->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldCalendriers->libelle;
        $oldCrudData['type'] = $oldCalendriers->type;
        $oldCrudData['description'] = $oldCalendriers->description;
        $oldCrudData['identifiants_sadge'] = $oldCalendriers->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldCalendriers->creat_by;


        if (!empty($data['libelle'])) {
            $Calendriers->libelle = $data['libelle'];
        }
        if (!empty($data['type'])) {
            $Calendriers->type = $data['type'];
        }
        if (!empty($data['description'])) {
            $Calendriers->description = $data['description'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Calendriers->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Calendriers->creat_by = $data['creat_by'];
        }
        $Calendriers->save();
        $Calendriers = \App\Models\Calendrier::find($Calendriers->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Calendriers->libelle;
        $newCrudData['type'] = $Calendriers->type;
        $newCrudData['description'] = $Calendriers->description;
        $newCrudData['identifiants_sadge'] = $Calendriers->identifiants_sadge;
        $newCrudData['creat_by'] = $Calendriers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Calendriers', 'entite_cle' => $Calendriers->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Calendriers->toArray();
        return $data;
    }

}
