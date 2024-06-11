<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTraitementExecUseCase
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

        $Traitements = new \App\Models\Traitement();

        if (!empty($data['libelle'])) {
            $Traitements->libelle = $data['libelle'];
        }
        if (!empty($data['date'])) {
            $Traitements->date = $data['date'];
        }
        if (!empty($data['etat_depart'])) {
            $Traitements->etat_depart = $data['etat_depart'];
        }
        if (!empty($data['etat_arrive'])) {
            $Traitements->etat_arrive = $data['etat_arrive'];
        }
        if (!empty($data['transaction_id'])) {
            $Traitements->transaction_id = $data['transaction_id'];
        }
        if (!empty($data['creat_by'])) {
            $Traitements->creat_by = $data['creat_by'];
        }
        $Traitements->save();
        $Traitements = \App\Models\Traitement::find($Traitements->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Traitements', 'entite_cle' => $Traitements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Traitements->toArray();
        return $data;
    }

}
