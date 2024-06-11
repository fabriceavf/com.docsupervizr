<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDeploiementspointeusesmoyenstransportExecUseCase
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

        $Deploiementspointeusesmoyenstransports = \App\Models\Deploiementspointeusesmoyenstransport::find($data['id']);
        $oldDeploiementspointeusesmoyenstransports = $Deploiementspointeusesmoyenstransports->replicate();

        $oldCrudData = [];
        $oldCrudData['date'] = $oldDeploiementspointeusesmoyenstransports->date;
        $oldCrudData['pointeuse_id'] = $oldDeploiementspointeusesmoyenstransports->pointeuse_id;
        $oldCrudData['moyenstransport_id'] = $oldDeploiementspointeusesmoyenstransports->moyenstransport_id;
        $oldCrudData['debut'] = $oldDeploiementspointeusesmoyenstransports->debut;
        $oldCrudData['fin'] = $oldDeploiementspointeusesmoyenstransports->fin;
        $oldCrudData['creat_by'] = $oldDeploiementspointeusesmoyenstransports->creat_by;
        try {
            $oldCrudData['moyenstransport'] = $oldDeploiementspointeusesmoyenstransports->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $oldDeploiementspointeusesmoyenstransports->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Deploiementspointeusesmoyenstransports', 'entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Deploiementspointeusesmoyenstransports->toArray();
        return $data;
    }

}
