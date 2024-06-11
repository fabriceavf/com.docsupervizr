<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateAssignationExecUseCase
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

        $Assignations = new \App\Models\Assignation();

        if (!empty($data['date'])) {
            $Assignations->date = $data['date'];
        }
        if (!empty($data['user_id'])) {
            $Assignations->user_id = $data['user_id'];
        }
        if (!empty($data['carte_id'])) {
            $Assignations->carte_id = $data['carte_id'];
        }
        if (!empty($data['debut'])) {
            $Assignations->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Assignations->fin = $data['fin'];
        }
        if (!empty($data['creat_by'])) {
            $Assignations->creat_by = $data['creat_by'];
        }
        $Assignations->save();
        $Assignations = \App\Models\Assignation::find($Assignations->id);
        $newCrudData = [];
        $newCrudData['date'] = $Assignations->date;
        $newCrudData['user_id'] = $Assignations->user_id;
        $newCrudData['carte_id'] = $Assignations->carte_id;
        $newCrudData['debut'] = $Assignations->debut;
        $newCrudData['fin'] = $Assignations->fin;
        $newCrudData['creat_by'] = $Assignations->creat_by;
        try {
            $newCrudData['carte'] = $Assignations->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Assignations->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Assignations', 'entite_cle' => $Assignations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Assignations->toArray();
        return $data;
    }

}
