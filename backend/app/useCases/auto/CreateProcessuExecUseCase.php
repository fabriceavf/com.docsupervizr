<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProcessuExecUseCase
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

        $Processus = new \App\Models\Processu();

        if (!empty($data['libelle'])) {
            $Processus->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Processus->description = $data['description'];
        }
        if (!empty($data['valide_one'])) {
            $Processus->valide_one = $data['valide_one'];
        }
        if (!empty($data['valide_two'])) {
            $Processus->valide_two = $data['valide_two'];
        }
        if (!empty($data['work_id'])) {
            $Processus->work_id = $data['work_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Processus->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Processus->creat_by = $data['creat_by'];
        }
        $Processus->save();
        $Processus = \App\Models\Processu::find($Processus->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Processus->libelle;
        $newCrudData['description'] = $Processus->description;
        $newCrudData['valide_one'] = $Processus->valide_one;
        $newCrudData['valide_two'] = $Processus->valide_two;
        $newCrudData['work_id'] = $Processus->work_id;
        $newCrudData['identifiants_sadge'] = $Processus->identifiants_sadge;
        $newCrudData['creat_by'] = $Processus->creat_by;
        try {
            $newCrudData['work'] = $Processus->work->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Processus', 'entite_cle' => $Processus->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Processus->toArray();
        return $data;
    }

}
