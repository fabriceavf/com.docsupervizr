<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateGroupedirectionExecUseCase
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

        $Groupedirections = new \App\Models\Groupedirection();

        if (!empty($data['libelle'])) {
            $Groupedirections->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Groupedirections->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Groupedirections->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Groupedirections->save();
        $Groupedirections = \App\Models\Groupedirection::find($Groupedirections->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Groupedirections->libelle;
        $newCrudData['creat_by'] = $Groupedirections->creat_by;
        $newCrudData['identifiants_sadge'] = $Groupedirections->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Groupedirections', 'entite_cle' => $Groupedirections->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Groupedirections->toArray();
        return $data;
    }

}
