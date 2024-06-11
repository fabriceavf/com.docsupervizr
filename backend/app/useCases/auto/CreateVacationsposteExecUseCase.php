<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateVacationsposteExecUseCase
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

        $Vacationspostes = new \App\Models\Vacationsposte();

        if (!empty($data['total'])) {
            $Vacationspostes->total = $data['total'];
        }
        if (!empty($data['date'])) {
            $Vacationspostes->date = $data['date'];
        }
        if (!empty($data['poste_id'])) {
            $Vacationspostes->poste_id = $data['poste_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Vacationspostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Vacationspostes->creat_by = $data['creat_by'];
        }
        $Vacationspostes->save();
        $Vacationspostes = \App\Models\Vacationsposte::find($Vacationspostes->id);
        $newCrudData = [];
        $newCrudData['total'] = $Vacationspostes->total;
        $newCrudData['date'] = $Vacationspostes->date;
        $newCrudData['poste_id'] = $Vacationspostes->poste_id;
        $newCrudData['identifiants_sadge'] = $Vacationspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Vacationspostes->creat_by;
        try {
            $newCrudData['poste'] = $Vacationspostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Vacationspostes', 'entite_cle' => $Vacationspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Vacationspostes->toArray();
        return $data;
    }

}
