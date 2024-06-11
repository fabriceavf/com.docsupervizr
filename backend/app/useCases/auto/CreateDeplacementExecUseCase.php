<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDeplacementExecUseCase
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

        $Deplacements = new \App\Models\Deplacement();

        if (!empty($data['date'])) {
            $Deplacements->date = $data['date'];
        }
        if (!empty($data['debut_prevu'])) {
            $Deplacements->debut_prevu = $data['debut_prevu'];
        }
        if (!empty($data['fin_prevu'])) {
            $Deplacements->fin_prevu = $data['fin_prevu'];
        }
        if (!empty($data['lignesmoyenstransport_id'])) {
            $Deplacements->lignesmoyenstransport_id = $data['lignesmoyenstransport_id'];
        }
        if (!empty($data['creat_by'])) {
            $Deplacements->creat_by = $data['creat_by'];
        }
        if (!empty($data['moyenstransport_id'])) {
            $Deplacements->moyenstransport_id = $data['moyenstransport_id'];
        }
        if (!empty($data['ligne_id'])) {
            $Deplacements->ligne_id = $data['ligne_id'];
        }
        $Deplacements->save();
        $Deplacements = \App\Models\Deplacement::find($Deplacements->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Deplacements', 'entite_cle' => $Deplacements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Deplacements->toArray();
        return $data;
    }

}
