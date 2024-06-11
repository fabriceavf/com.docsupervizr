<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionspostessyntheseExecUseCase
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

        $Transactionspostessyntheses = new \App\Models\Transactionspostessynthese();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionspostessyntheses', 'entite_cle' => $Transactionspostessyntheses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionspostessyntheses->toArray();
        return $data;
    }

}
