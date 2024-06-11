<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListingsjourExecUseCase
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

        $Listingsjours = \App\Models\Listingsjour::find($data['id']);


        $Listingsjours->deleted_at = now();
        $Listingsjours->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Listingsjours->libelle;
        $newCrudData['date'] = $Listingsjours->date;
        $newCrudData['etats'] = $Listingsjours->etats;
        $newCrudData['user'] = $Listingsjours->user;
        $newCrudData['identifiants_sadge'] = $Listingsjours->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingsjours->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listingsjours', 'entite_cle' => $Listingsjours->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
