<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionspostessyntheseExecUseCase
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

        $Transactionspostessyntheses = \App\Models\Transactionspostessynthese::find($data['id']);
        $oldTransactionspostessyntheses = $Transactionspostessyntheses->replicate();

        $oldCrudData = [];
        $oldCrudData['transactions_totals'] = $oldTransactionspostessyntheses->transactions_totals;
        $oldCrudData['transactions_id'] = $oldTransactionspostessyntheses->transactions_id;
        $oldCrudData['transactions_matricule'] = $oldTransactionspostessyntheses->transactions_matricule;
        $oldCrudData['transactions_heures'] = $oldTransactionspostessyntheses->transactions_heures;
        $oldCrudData['date'] = $oldTransactionspostessyntheses->date;
        $oldCrudData['poste_id'] = $oldTransactionspostessyntheses->poste_id;
        try {
            $oldCrudData['poste'] = $oldTransactionspostessyntheses->poste->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['transactions_totals'])) {
            $Transactionspostessyntheses->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['transactions_id'])) {
            $Transactionspostessyntheses->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['transactions_matricule'])) {
            $Transactionspostessyntheses->transactions_matricule = $data['transactions_matricule'];
        }
        if (!empty($data['transactions_heures'])) {
            $Transactionspostessyntheses->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['date'])) {
            $Transactionspostessyntheses->date = $data['date'];
        }
        if (!empty($data['poste_id'])) {
            $Transactionspostessyntheses->poste_id = $data['poste_id'];
        }
        $Transactionspostessyntheses->save();
        $Transactionspostessyntheses = \App\Models\Transactionspostessynthese::find($Transactionspostessyntheses->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionspostessyntheses->transactions_totals;
        $newCrudData['transactions_id'] = $Transactionspostessyntheses->transactions_id;
        $newCrudData['transactions_matricule'] = $Transactionspostessyntheses->transactions_matricule;
        $newCrudData['transactions_heures'] = $Transactionspostessyntheses->transactions_heures;
        $newCrudData['date'] = $Transactionspostessyntheses->date;
        $newCrudData['poste_id'] = $Transactionspostessyntheses->poste_id;
        try {
            $newCrudData['poste'] = $Transactionspostessyntheses->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionspostessyntheses', 'entite_cle' => $Transactionspostessyntheses->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionspostessyntheses->toArray();
        return $data;
    }

}
