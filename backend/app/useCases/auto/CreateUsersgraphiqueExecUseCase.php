<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateUsersgraphiqueExecUseCase
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

        $Usersgraphiques = new \App\Models\Usersgraphique();

        if (!empty($data['user_id'])) {
            $Usersgraphiques->user_id = $data['user_id'];
        }
        if (!empty($data['graphique_id'])) {
            $Usersgraphiques->graphique_id = $data['graphique_id'];
        }
        if (!empty($data['creat_by'])) {
            $Usersgraphiques->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Usersgraphiques->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Usersgraphiques->save();
        $Usersgraphiques = \App\Models\Usersgraphique::find($Usersgraphiques->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Usersgraphiques->user_id;
        $newCrudData['graphique_id'] = $Usersgraphiques->graphique_id;
        $newCrudData['creat_by'] = $Usersgraphiques->creat_by;
        $newCrudData['identifiants_sadge'] = $Usersgraphiques->identifiants_sadge;
        try {
            $newCrudData['graphique'] = $Usersgraphiques->graphique->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Usersgraphiques->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Usersgraphiques', 'entite_cle' => $Usersgraphiques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Usersgraphiques->toArray();
        return $data;
    }

}
