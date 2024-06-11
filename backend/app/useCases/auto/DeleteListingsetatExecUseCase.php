<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListingsetatExecUseCase
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

        $Listingsetats = \App\Models\Listingsetat::find($data['id']);


        $Listingsetats->deleted_at = now();
        $Listingsetats->save();
        $newCrudData = [];
        $newCrudData['listingsjour_id'] = $Listingsetats->listingsjour_id;
        $newCrudData['user_id'] = $Listingsetats->user_id;
        $newCrudData['present'] = $Listingsetats->present;
        $newCrudData['identifiants_sadge'] = $Listingsetats->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingsetats->creat_by;
        try {
            $newCrudData['listingsjour'] = $Listingsetats->listingsjour->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Listingsetats->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listingsetats', 'entite_cle' => $Listingsetats->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
