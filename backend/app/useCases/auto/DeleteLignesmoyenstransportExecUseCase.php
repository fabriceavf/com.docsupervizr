<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteLignesmoyenstransportExecUseCase
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

        $Lignesmoyenstransports = \App\Models\Lignesmoyenstransport::find($data['id']);


        $Lignesmoyenstransports->deleted_at = now();
        $Lignesmoyenstransports->save();
        $newCrudData = [];
        $newCrudData['moyenstransport_id'] = $Lignesmoyenstransports->moyenstransport_id;
        $newCrudData['ligne_id'] = $Lignesmoyenstransports->ligne_id;
        $newCrudData['heure_debut'] = $Lignesmoyenstransports->heure_debut;
        $newCrudData['heure_fin'] = $Lignesmoyenstransports->heure_fin;
        $newCrudData['lun'] = $Lignesmoyenstransports->lun;
        $newCrudData['mar'] = $Lignesmoyenstransports->mar;
        $newCrudData['mer'] = $Lignesmoyenstransports->mer;
        $newCrudData['jeu'] = $Lignesmoyenstransports->jeu;
        $newCrudData['ven'] = $Lignesmoyenstransports->ven;
        $newCrudData['sam'] = $Lignesmoyenstransports->sam;
        $newCrudData['dim'] = $Lignesmoyenstransports->dim;
        $newCrudData['creat_by'] = $Lignesmoyenstransports->creat_by;
        try {
            $newCrudData['ligne'] = $Lignesmoyenstransports->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Lignesmoyenstransports->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Lignesmoyenstransports', 'entite_cle' => $Lignesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
