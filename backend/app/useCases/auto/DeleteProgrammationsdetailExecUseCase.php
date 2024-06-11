<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammationsdetailExecUseCase
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


        $Programmationsdetails->deleted_at = now();
        $Programmationsdetails->save();
        $newCrudData = [];
        $newCrudData['debut'] = $Programmationsdetails->debut;
        $newCrudData['fin'] = $Programmationsdetails->fin;
        $newCrudData['users'] = $Programmationsdetails->users;
        $newCrudData['programmation_id'] = $Programmationsdetails->programmation_id;
        try {
            $newCrudData['programmation'] = $Programmationsdetails->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmationsdetails', 'entite_cle' => $Programmationsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
