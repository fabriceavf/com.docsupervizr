<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesmoyenstransportExecUseCase
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

        $Typesmoyenstransports = \App\Models\Typesmoyenstransport::find($data['id']);


        $Typesmoyenstransports->deleted_at = now();
        $Typesmoyenstransports->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typesmoyenstransports->code;
        $newCrudData['libelle'] = $Typesmoyenstransports->libelle;
        $newCrudData['canCreate'] = $Typesmoyenstransports->canCreate;
        $newCrudData['canUpdate'] = $Typesmoyenstransports->canUpdate;
        $newCrudData['canDelete'] = $Typesmoyenstransports->canDelete;
        $newCrudData['creat_by'] = $Typesmoyenstransports->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typesmoyenstransports', 'entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
