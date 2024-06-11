<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransporteurstrajetExecUseCase
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

        $Transporteurstrajets = new \App\Models\Transporteurstrajet();

        if (!empty($data['transporteur_id'])) {
            $Transporteurstrajets->transporteur_id = $data['transporteur_id'];
        }
        if (!empty($data['trajet_id'])) {
            $Transporteurstrajets->trajet_id = $data['trajet_id'];
        }
        if (!empty($data['montant'])) {
            $Transporteurstrajets->montant = $data['montant'];
        }
        if (!empty($data['debut'])) {
            $Transporteurstrajets->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Transporteurstrajets->fin = $data['fin'];
        }
        if (!empty($data['creat_by'])) {
            $Transporteurstrajets->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transporteurstrajets->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Transporteurstrajets->save();
        $Transporteurstrajets = \App\Models\Transporteurstrajet::find($Transporteurstrajets->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transporteurstrajets', 'entite_cle' => $Transporteurstrajets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transporteurstrajets->toArray();
        return $data;
    }

}
