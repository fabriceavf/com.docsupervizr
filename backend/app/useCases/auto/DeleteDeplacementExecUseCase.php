<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDeplacementExecUseCase
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

        $Deplacements = \App\Models\Deplacement::find($data['id']);


        $Deplacements->deleted_at = now();
        $Deplacements->save();
        $newCrudData = [];
        $newCrudData['date'] = $Deplacements->date;
        $newCrudData['debut_prevu'] = $Deplacements->debut_prevu;
        $newCrudData['fin_prevu'] = $Deplacements->fin_prevu;
        $newCrudData['lignesmoyenstransport_id'] = $Deplacements->lignesmoyenstransport_id;
        $newCrudData['creat_by'] = $Deplacements->creat_by;
        $newCrudData['moyenstransport_id'] = $Deplacements->moyenstransport_id;
        $newCrudData['ligne_id'] = $Deplacements->ligne_id;
        try {
            $newCrudData['ligne'] = $Deplacements->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['lignesmoyenstransport'] = $Deplacements->lignesmoyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Deplacements->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Deplacements', 'entite_cle' => $Deplacements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
