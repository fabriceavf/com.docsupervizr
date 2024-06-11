<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateLignesmoyenstransportExecUseCase
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

        $Lignesmoyenstransports = new \App\Models\Lignesmoyenstransport();

        if (!empty($data['moyenstransport_id'])) {
            $Lignesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        }
        if (!empty($data['ligne_id'])) {
            $Lignesmoyenstransports->ligne_id = $data['ligne_id'];
        }
        if (!empty($data['heure_debut'])) {
            $Lignesmoyenstransports->heure_debut = $data['heure_debut'];
        }
        if (!empty($data['heure_fin'])) {
            $Lignesmoyenstransports->heure_fin = $data['heure_fin'];
        }
        if (!empty($data['lun'])) {
            $Lignesmoyenstransports->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Lignesmoyenstransports->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Lignesmoyenstransports->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Lignesmoyenstransports->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Lignesmoyenstransports->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Lignesmoyenstransports->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Lignesmoyenstransports->dim = $data['dim'];
        }
        if (!empty($data['creat_by'])) {
            $Lignesmoyenstransports->creat_by = $data['creat_by'];
        }
        $Lignesmoyenstransports->save();
        $Lignesmoyenstransports = \App\Models\Lignesmoyenstransport::find($Lignesmoyenstransports->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Lignesmoyenstransports', 'entite_cle' => $Lignesmoyenstransports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Lignesmoyenstransports->toArray();
        return $data;
    }

}
