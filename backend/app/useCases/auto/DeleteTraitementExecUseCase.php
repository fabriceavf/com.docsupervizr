<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTraitementExecUseCase
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

        $Traitements = \App\Models\Traitement::find($data['id']);


        $Traitements->deleted_at = now();
        $Traitements->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Traitements->libelle;
        $newCrudData['date'] = $Traitements->date;
        $newCrudData['etat_depart'] = $Traitements->etat_depart;
        $newCrudData['etat_arrive'] = $Traitements->etat_arrive;
        $newCrudData['transaction_id'] = $Traitements->transaction_id;
        $newCrudData['creat_by'] = $Traitements->creat_by;
        try {
            $newCrudData['transaction'] = $Traitements->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Traitements', 'entite_cle' => $Traitements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
