<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAssignationExecUseCase
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
        $oldAssignations = $Assignations->replicate();

        $oldCrudData = [];
        $oldCrudData['date'] = $oldAssignations->date;
        $oldCrudData['user_id'] = $oldAssignations->user_id;
        $oldCrudData['carte_id'] = $oldAssignations->carte_id;
        $oldCrudData['debut'] = $oldAssignations->debut;
        $oldCrudData['fin'] = $oldAssignations->fin;
        $oldCrudData['creat_by'] = $oldAssignations->creat_by;
        try {
            $oldCrudData['carte'] = $oldAssignations->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldAssignations->user->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Assignations', 'entite_cle' => $Assignations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Assignations->toArray();
        return $data;
    }

}
