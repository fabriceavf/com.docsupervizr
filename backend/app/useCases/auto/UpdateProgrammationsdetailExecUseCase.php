<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProgrammationsdetailExecUseCase
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

        $Programmationsdetails = \App\Models\Programmationsdetail::find($data['id']);
        $oldProgrammationsdetails = $Programmationsdetails->replicate();

        $oldCrudData = [];
        $oldCrudData['debut'] = $oldProgrammationsdetails->debut;
        $oldCrudData['fin'] = $oldProgrammationsdetails->fin;
        $oldCrudData['users'] = $oldProgrammationsdetails->users;
        $oldCrudData['programmation_id'] = $oldProgrammationsdetails->programmation_id;
        try {
            $oldCrudData['programmation'] = $oldProgrammationsdetails->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['debut'])) {
            $Programmationsdetails->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Programmationsdetails->fin = $data['fin'];
        }
        if (!empty($data['users'])) {
            $Programmationsdetails->users = $data['users'];
        }
        if (!empty($data['programmation_id'])) {
            $Programmationsdetails->programmation_id = $data['programmation_id'];
        }
        $Programmationsdetails->save();
        $Programmationsdetails = \App\Models\Programmationsdetail::find($Programmationsdetails->id);
        $newCrudData = [];
        $newCrudData['debut'] = $Programmationsdetails->debut;
        $newCrudData['fin'] = $Programmationsdetails->fin;
        $newCrudData['users'] = $Programmationsdetails->users;
        $newCrudData['programmation_id'] = $Programmationsdetails->programmation_id;
        try {
            $newCrudData['programmation'] = $Programmationsdetails->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Programmationsdetails', 'entite_cle' => $Programmationsdetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmationsdetails->toArray();
        return $data;
    }

}
