<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDoublonsPosteExecUseCase
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

        $DoublonsPostes = \App\Models\DoublonsPoste::find($data['id']);


        $DoublonsPostes->deleted_at = now();
        $DoublonsPostes->save();
        $newCrudData = [];
        $newCrudData['ancienHoraire'] = $DoublonsPostes->ancienHoraire;
        $newCrudData['nouveauHoraire'] = $DoublonsPostes->nouveauHoraire;
        $newCrudData['identifiants_sadge'] = $DoublonsPostes->identifiants_sadge;
        $newCrudData['creat_by'] = $DoublonsPostes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'DoublonsPostes', 'entite_cle' => $DoublonsPostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
