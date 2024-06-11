<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypesmoyenstransportExecUseCase
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
        $oldTypesmoyenstransports = $Typesmoyenstransports->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTypesmoyenstransports->code;
        $oldCrudData['libelle'] = $oldTypesmoyenstransports->libelle;
        $oldCrudData['canCreate'] = $oldTypesmoyenstransports->canCreate;
        $oldCrudData['canUpdate'] = $oldTypesmoyenstransports->canUpdate;
        $oldCrudData['canDelete'] = $oldTypesmoyenstransports->canDelete;
        $oldCrudData['creat_by'] = $oldTypesmoyenstransports->creat_by;


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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typesmoyenstransports', 'entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesmoyenstransports->toArray();
        return $data;
    }

}
