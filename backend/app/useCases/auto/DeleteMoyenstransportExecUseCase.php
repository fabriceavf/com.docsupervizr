<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMoyenstransportExecUseCase
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


        $Moyenstransports->deleted_at = now();
        $Moyenstransports->save();
        $newCrudData = [];
        $newCrudData['code'] = $Moyenstransports->code;
        $newCrudData['libelle'] = $Moyenstransports->libelle;
        $newCrudData['typesmoyenstransport_id'] = $Moyenstransports->typesmoyenstransport_id;
        $newCrudData['creat_by'] = $Moyenstransports->creat_by;
        try {
            $newCrudData['typesmoyenstransport'] = $Moyenstransports->typesmoyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Moyenstransports', 'entite_cle' => $Moyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
