<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMoyenstransportExecUseCase
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

        $Moyenstransports = \App\Models\Moyenstransport::find($data['id']);
        $oldMoyenstransports = $Moyenstransports->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldMoyenstransports->code;
        $oldCrudData['libelle'] = $oldMoyenstransports->libelle;
        $oldCrudData['typesmoyenstransport_id'] = $oldMoyenstransports->typesmoyenstransport_id;
        $oldCrudData['creat_by'] = $oldMoyenstransports->creat_by;
        try {
            $oldCrudData['typesmoyenstransport'] = $oldMoyenstransports->typesmoyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['code'])) {
            $Moyenstransports->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Moyenstransports->libelle = $data['libelle'];
        }
        if (!empty($data['typesmoyenstransport_id'])) {
            $Moyenstransports->typesmoyenstransport_id = $data['typesmoyenstransport_id'];
        }
        if (!empty($data['creat_by'])) {
            $Moyenstransports->creat_by = $data['creat_by'];
        }
        $Moyenstransports->save();
        $Moyenstransports = \App\Models\Moyenstransport::find($Moyenstransports->id);
        $newCrudData = [];
        $newCrudData['code'] = $Moyenstransports->code;
        $newCrudData['libelle'] = $Moyenstransports->libelle;
        $newCrudData['typesmoyenstransport_id'] = $Moyenstransports->typesmoyenstransport_id;
        $newCrudData['creat_by'] = $Moyenstransports->creat_by;
        try {
            $newCrudData['typesmoyenstransport'] = $Moyenstransports->typesmoyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Moyenstransports', 'entite_cle' => $Moyenstransports->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Moyenstransports->toArray();
        return $data;
    }

}
