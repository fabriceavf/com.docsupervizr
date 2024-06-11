<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDoublonsPosteExecUseCase
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
        $oldDoublonsPostes = $DoublonsPostes->replicate();

        $oldCrudData = [];
        $oldCrudData['ancienHoraire'] = $oldDoublonsPostes->ancienHoraire;
        $oldCrudData['nouveauHoraire'] = $oldDoublonsPostes->nouveauHoraire;
        $oldCrudData['identifiants_sadge'] = $oldDoublonsPostes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldDoublonsPostes->creat_by;


        if (!empty($data['ancienHoraire'])) {
            $DoublonsPostes->ancienHoraire = $data['ancienHoraire'];
        }
        if (!empty($data['nouveauHoraire'])) {
            $DoublonsPostes->nouveauHoraire = $data['nouveauHoraire'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $DoublonsPostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $DoublonsPostes->creat_by = $data['creat_by'];
        }
        $DoublonsPostes->save();
        $DoublonsPostes = \App\Models\DoublonsPoste::find($DoublonsPostes->id);
        $newCrudData = [];
        $newCrudData['ancienHoraire'] = $DoublonsPostes->ancienHoraire;
        $newCrudData['nouveauHoraire'] = $DoublonsPostes->nouveauHoraire;
        $newCrudData['identifiants_sadge'] = $DoublonsPostes->identifiants_sadge;
        $newCrudData['creat_by'] = $DoublonsPostes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'DoublonsPostes', 'entite_cle' => $DoublonsPostes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $DoublonsPostes->toArray();
        return $data;
    }

}
