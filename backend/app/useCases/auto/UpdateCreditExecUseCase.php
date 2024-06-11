<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateCreditExecUseCase
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
        $oldCredits = $Credits->replicate();

        $oldCrudData = [];
        $oldCrudData['identification_id'] = $oldCredits->identification_id;
        $oldCrudData['montant'] = $oldCredits->montant;
        $oldCrudData['creat_by'] = $oldCredits->creat_by;
        try {
            $oldCrudData['identification'] = $oldCredits->identification->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['identification_id'])) {
            $Credits->identification_id = $data['identification_id'];
        }
        if (!empty($data['montant'])) {
            $Credits->montant = $data['montant'];
        }
        if (!empty($data['creat_by'])) {
            $Credits->creat_by = $data['creat_by'];
        }
        $Credits->save();
        $Credits = \App\Models\Credit::find($Credits->id);
        $newCrudData = [];
        $newCrudData['identification_id'] = $Credits->identification_id;
        $newCrudData['montant'] = $Credits->montant;
        $newCrudData['creat_by'] = $Credits->creat_by;
        try {
            $newCrudData['identification'] = $Credits->identification->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Credits', 'entite_cle' => $Credits->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Credits->toArray();
        return $data;
    }

}
