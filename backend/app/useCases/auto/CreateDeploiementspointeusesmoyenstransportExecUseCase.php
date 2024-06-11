<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDeploiementspointeusesmoyenstransportExecUseCase
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

        $Deploiementspointeusesmoyenstransports = new \App\Models\Deploiementspointeusesmoyenstransport();

        if (!empty($data['date'])) {
            $Deploiementspointeusesmoyenstransports->date = $data['date'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Deploiementspointeusesmoyenstransports->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['moyenstransport_id'])) {
            $Deploiementspointeusesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        }
        if (!empty($data['debut'])) {
            $Deploiementspointeusesmoyenstransports->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Deploiementspointeusesmoyenstransports->fin = $data['fin'];
        }
        if (!empty($data['creat_by'])) {
            $Deploiementspointeusesmoyenstransports->creat_by = $data['creat_by'];
        }
        $Deploiementspointeusesmoyenstransports->save();
        $Deploiementspointeusesmoyenstransports = \App\Models\Deploiementspointeusesmoyenstransport::find($Deploiementspointeusesmoyenstransports->id);
        $newCrudData = [];
        $newCrudData['date'] = $Deploiementspointeusesmoyenstransports->date;
        $newCrudData['pointeuse_id'] = $Deploiementspointeusesmoyenstransports->pointeuse_id;
        $newCrudData['moyenstransport_id'] = $Deploiementspointeusesmoyenstransports->moyenstransport_id;
        $newCrudData['debut'] = $Deploiementspointeusesmoyenstransports->debut;
        $newCrudData['fin'] = $Deploiementspointeusesmoyenstransports->fin;
        $newCrudData['creat_by'] = $Deploiementspointeusesmoyenstransports->creat_by;
        try {
            $newCrudData['moyenstransport'] = $Deploiementspointeusesmoyenstransports->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Deploiementspointeusesmoyenstransports->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Deploiementspointeusesmoyenstransports', 'entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Deploiementspointeusesmoyenstransports->toArray();
        return $data;
    }

}
