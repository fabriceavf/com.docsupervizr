<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypesmoyenstransportExecUseCase
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

        $Typesmoyenstransports = new \App\Models\Typesmoyenstransport();

        if (!empty($data['code'])) {
            $Typesmoyenstransports->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typesmoyenstransports->libelle = $data['libelle'];
        }
        if (!empty($data['canCreate'])) {
            $Typesmoyenstransports->canCreate = $data['canCreate'];
        }
        if (!empty($data['canUpdate'])) {
            $Typesmoyenstransports->canUpdate = $data['canUpdate'];
        }
        if (!empty($data['canDelete'])) {
            $Typesmoyenstransports->canDelete = $data['canDelete'];
        }
        if (!empty($data['creat_by'])) {
            $Typesmoyenstransports->creat_by = $data['creat_by'];
        }
        $Typesmoyenstransports->save();
        $Typesmoyenstransports = \App\Models\Typesmoyenstransport::find($Typesmoyenstransports->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typesmoyenstransports->code;
        $newCrudData['libelle'] = $Typesmoyenstransports->libelle;
        $newCrudData['canCreate'] = $Typesmoyenstransports->canCreate;
        $newCrudData['canUpdate'] = $Typesmoyenstransports->canUpdate;
        $newCrudData['canDelete'] = $Typesmoyenstransports->canDelete;
        $newCrudData['creat_by'] = $Typesmoyenstransports->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typesmoyenstransports', 'entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesmoyenstransports->toArray();
        return $data;
    }

}
