<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRapportposteExecUseCase
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

        $Rapportpostes = new \App\Models\Rapportposte();

        if (!empty($data['total'])) {
            $Rapportpostes->total = $data['total'];
        }
        if (!empty($data['date'])) {
            $Rapportpostes->date = $data['date'];
        }
        if (!empty($data['poste_id'])) {
            $Rapportpostes->poste_id = $data['poste_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Rapportpostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Rapportpostes->creat_by = $data['creat_by'];
        }
        $Rapportpostes->save();
        $Rapportpostes = \App\Models\Rapportposte::find($Rapportpostes->id);
        $newCrudData = [];
        $newCrudData['total'] = $Rapportpostes->total;
        $newCrudData['date'] = $Rapportpostes->date;
        $newCrudData['poste_id'] = $Rapportpostes->poste_id;
        $newCrudData['identifiants_sadge'] = $Rapportpostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Rapportpostes->creat_by;
        try {
            $newCrudData['poste'] = $Rapportpostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Rapportpostes', 'entite_cle' => $Rapportpostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Rapportpostes->toArray();
        return $data;
    }

}
