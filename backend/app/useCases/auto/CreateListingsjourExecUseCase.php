<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateListingsjourExecUseCase
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

        $Listingsjours = new \App\Models\Listingsjour();

        if (!empty($data['libelle'])) {
            $Listingsjours->libelle = $data['libelle'];
        }
        if (!empty($data['date'])) {
            $Listingsjours->date = $data['date'];
        }
        if (!empty($data['etats'])) {
            $Listingsjours->etats = $data['etats'];
        }
        if (!empty($data['user'])) {
            $Listingsjours->user = $data['user'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Listingsjours->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Listingsjours->creat_by = $data['creat_by'];
        }
        $Listingsjours->save();
        $Listingsjours = \App\Models\Listingsjour::find($Listingsjours->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Listingsjours->libelle;
        $newCrudData['date'] = $Listingsjours->date;
        $newCrudData['etats'] = $Listingsjours->etats;
        $newCrudData['user'] = $Listingsjours->user;
        $newCrudData['identifiants_sadge'] = $Listingsjours->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingsjours->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Listingsjours', 'entite_cle' => $Listingsjours->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listingsjours->toArray();
        return $data;
    }

}
