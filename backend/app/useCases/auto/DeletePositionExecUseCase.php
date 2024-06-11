<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePositionExecUseCase
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

        $Positions = \App\Models\Position::find($data['id']);


        $Positions->deleted_at = now();
        $Positions->save();
        $newCrudData = [];
        $newCrudData['lat'] = $Positions->lat;
        $newCrudData['lon'] = $Positions->lon;
        $newCrudData['name'] = $Positions->name;
        $newCrudData['title'] = $Positions->title;
        $newCrudData['speed'] = $Positions->speed;
        $newCrudData['icon_color'] = $Positions->icon_color;
        $newCrudData['moyenstransportid'] = $Positions->moyenstransportid;
        $newCrudData['creat_by'] = $Positions->creat_by;
        $newCrudData['date'] = $Positions->date;
        $newCrudData['tracername'] = $Positions->tracername;
        $newCrudData['traceruniqueid'] = $Positions->traceruniqueid;
        $newCrudData['sim'] = $Positions->sim;
        $newCrudData['balise_id'] = $Positions->balise_id;
        try {
            $newCrudData['balise'] = $Positions->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Positions', 'entite_cle' => $Positions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
