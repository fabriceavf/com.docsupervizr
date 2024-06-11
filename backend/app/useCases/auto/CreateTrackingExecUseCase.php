<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTrackingExecUseCase
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

        $Trackings = new \App\Models\Tracking();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Trackings', 'entite_cle' => $Trackings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Trackings->toArray();
        return $data;
    }

}
