<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCreditExecUseCase
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

        $Credits = \App\Models\Credit::find($data['id']);


        $Credits->deleted_at = now();
        $Credits->save();
        $newCrudData = [];
        $newCrudData['identification_id'] = $Credits->identification_id;
        $newCrudData['montant'] = $Credits->montant;
        $newCrudData['creat_by'] = $Credits->creat_by;
        try {
            $newCrudData['identification'] = $Credits->identification->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Credits', 'entite_cle' => $Credits->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
