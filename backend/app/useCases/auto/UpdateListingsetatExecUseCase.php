<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateListingsetatExecUseCase
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
        $oldListingsetats = $Listingsetats->replicate();

        $oldCrudData = [];
        $oldCrudData['listingsjour_id'] = $oldListingsetats->listingsjour_id;
        $oldCrudData['user_id'] = $oldListingsetats->user_id;
        $oldCrudData['present'] = $oldListingsetats->present;
        $oldCrudData['identifiants_sadge'] = $oldListingsetats->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldListingsetats->creat_by;
        try {
            $oldCrudData['listingsjour'] = $oldListingsetats->listingsjour->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldListingsetats->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['listingsjour_id'])) {
            $Listingsetats->listingsjour_id = $data['listingsjour_id'];
        }
        if (!empty($data['user_id'])) {
            $Listingsetats->user_id = $data['user_id'];
        }
        if (!empty($data['present'])) {
            $Listingsetats->present = $data['present'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Listingsetats->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Listingsetats->creat_by = $data['creat_by'];
        }
        $Listingsetats->save();
        $Listingsetats = \App\Models\Listingsetat::find($Listingsetats->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Listingsetats', 'entite_cle' => $Listingsetats->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listingsetats->toArray();
        return $data;
    }

}
