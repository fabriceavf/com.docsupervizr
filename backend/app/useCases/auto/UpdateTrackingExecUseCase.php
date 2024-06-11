<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTrackingExecUseCase
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

        $Trackings = \App\Models\Tracking::find($data['id']);
        $oldTrackings = $Trackings->replicate();

        $oldCrudData = [];
        $oldCrudData['balise_id'] = $oldTrackings->balise_id;
        $oldCrudData['moyenstransport_id'] = $oldTrackings->moyenstransport_id;
        $oldCrudData['date_debut'] = $oldTrackings->date_debut;
        $oldCrudData['date_fin'] = $oldTrackings->date_fin;
        $oldCrudData['creat_by'] = $oldTrackings->creat_by;
        try {
            $oldCrudData['balise'] = $oldTrackings->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['moyenstransport'] = $oldTrackings->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['balise_id'])) {
            $Trackings->balise_id = $data['balise_id'];
        }
        if (!empty($data['moyenstransport_id'])) {
            $Trackings->moyenstransport_id = $data['moyenstransport_id'];
        }
        if (!empty($data['date_debut'])) {
            $Trackings->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Trackings->date_fin = $data['date_fin'];
        }
        if (!empty($data['creat_by'])) {
            $Trackings->creat_by = $data['creat_by'];
        }
        $Trackings->save();
        $Trackings = \App\Models\Tracking::find($Trackings->id);
        $newCrudData = [];
        $newCrudData['balise_id'] = $Trackings->balise_id;
        $newCrudData['moyenstransport_id'] = $Trackings->moyenstransport_id;
        $newCrudData['date_debut'] = $Trackings->date_debut;
        $newCrudData['date_fin'] = $Trackings->date_fin;
        $newCrudData['creat_by'] = $Trackings->creat_by;
        try {
            $newCrudData['balise'] = $Trackings->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Trackings->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Trackings', 'entite_cle' => $Trackings->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Trackings->toArray();
        return $data;
    }

}
