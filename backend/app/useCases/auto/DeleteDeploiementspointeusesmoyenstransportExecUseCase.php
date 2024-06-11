<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDeploiementspointeusesmoyenstransportExecUseCase
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


        $Deploiementspointeusesmoyenstransports->deleted_at = now();
        $Deploiementspointeusesmoyenstransports->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Deploiementspointeusesmoyenstransports', 'entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
