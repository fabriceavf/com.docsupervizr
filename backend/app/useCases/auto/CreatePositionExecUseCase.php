<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePositionExecUseCase
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

        $Positions = new \App\Models\Position();

        if (!empty($data['lat'])) {
            $Positions->lat = $data['lat'];
        }
        if (!empty($data['lon'])) {
            $Positions->lon = $data['lon'];
        }
        if (!empty($data['name'])) {
            $Positions->name = $data['name'];
        }
        if (!empty($data['title'])) {
            $Positions->title = $data['title'];
        }
        if (!empty($data['speed'])) {
            $Positions->speed = $data['speed'];
        }
        if (!empty($data['icon_color'])) {
            $Positions->icon_color = $data['icon_color'];
        }
        if (!empty($data['moyenstransportid'])) {
            $Positions->moyenstransportid = $data['moyenstransportid'];
        }
        if (!empty($data['creat_by'])) {
            $Positions->creat_by = $data['creat_by'];
        }
        if (!empty($data['date'])) {
            $Positions->date = $data['date'];
        }
        if (!empty($data['tracername'])) {
            $Positions->tracername = $data['tracername'];
        }
        if (!empty($data['traceruniqueid'])) {
            $Positions->traceruniqueid = $data['traceruniqueid'];
        }
        if (!empty($data['sim'])) {
            $Positions->sim = $data['sim'];
        }
        if (!empty($data['balise_id'])) {
            $Positions->balise_id = $data['balise_id'];
        }
        $Positions->save();
        $Positions = \App\Models\Position::find($Positions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Positions', 'entite_cle' => $Positions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Positions->toArray();
        return $data;
    }

}
