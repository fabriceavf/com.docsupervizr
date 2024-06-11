<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransporteurstrajetExecUseCase
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

        $Transporteurstrajets = \App\Models\Transporteurstrajet::find($data['id']);


        $Transporteurstrajets->deleted_at = now();
        $Transporteurstrajets->save();
        $newCrudData = [];
        $newCrudData['transporteur_id'] = $Transporteurstrajets->transporteur_id;
        $newCrudData['trajet_id'] = $Transporteurstrajets->trajet_id;
        $newCrudData['montant'] = $Transporteurstrajets->montant;
        $newCrudData['debut'] = $Transporteurstrajets->debut;
        $newCrudData['fin'] = $Transporteurstrajets->fin;
        $newCrudData['creat_by'] = $Transporteurstrajets->creat_by;
        $newCrudData['identifiants_sadge'] = $Transporteurstrajets->identifiants_sadge;
        try {
            $newCrudData['trajet'] = $Transporteurstrajets->trajet->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['transporteur'] = $Transporteurstrajets->transporteur->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transporteurstrajets', 'entite_cle' => $Transporteurstrajets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
