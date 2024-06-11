<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateCarteExecUseCase
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

        $Cartes = new \App\Models\Carte();

        if (!empty($data['code'])) {
            $Cartes->code = $data['code'];
        }
        if (!empty($data['uid_mifare'])) {
            $Cartes->uid_mifare = $data['uid_mifare'];
        }
        if (!empty($data['solde'])) {
            $Cartes->solde = $data['solde'];
        }
        if (!empty($data['site_id'])) {
            $Cartes->site_id = $data['site_id'];
        }
        if (!empty($data['etats'])) {
            $Cartes->etats = $data['etats'];
        }
        if (!empty($data['creat_by'])) {
            $Cartes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Cartes->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Cartes->save();
        $Cartes = \App\Models\Carte::find($Cartes->id);
        $newCrudData = [];
        $newCrudData['code'] = $Cartes->code;
        $newCrudData['uid_mifare'] = $Cartes->uid_mifare;
        $newCrudData['solde'] = $Cartes->solde;
        $newCrudData['site_id'] = $Cartes->site_id;
        $newCrudData['etats'] = $Cartes->etats;
        $newCrudData['creat_by'] = $Cartes->creat_by;
        $newCrudData['identifiants_sadge'] = $Cartes->identifiants_sadge;
        try {
            $newCrudData['site'] = $Cartes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Cartes', 'entite_cle' => $Cartes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Cartes->toArray();
        return $data;
    }

}
