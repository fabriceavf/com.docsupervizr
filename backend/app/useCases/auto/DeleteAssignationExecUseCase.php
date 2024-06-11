<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAssignationExecUseCase
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

        $Assignations = \App\Models\Assignation::find($data['id']);


        $Assignations->deleted_at = now();
        $Assignations->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Assignations', 'entite_cle' => $Assignations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
