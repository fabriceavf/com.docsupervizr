<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsdetailExecUseCase
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

        $Transactionsdetails = \App\Models\Transactionsdetail::find($data['id']);
        $oldTransactionsdetails = $Transactionsdetails->replicate();

        $oldCrudData = [];
        $oldCrudData['parent'] = $oldTransactionsdetails->parent;
        $oldCrudData['parentId'] = $oldTransactionsdetails->parentId;
        $oldCrudData['transaction_id'] = $oldTransactionsdetails->transaction_id;
        $oldCrudData['creat_by'] = $oldTransactionsdetails->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldTransactionsdetails->identifiants_sadge;
        try {
            $oldCrudData['transaction'] = $oldTransactionsdetails->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['parent'])) {
            $Transactionsdetails->parent = $data['parent'];
        }
        if (!empty($data['parentId'])) {
            $Transactionsdetails->parentId = $data['parentId'];
        }
        if (!empty($data['transaction_id'])) {
            $Transactionsdetails->transaction_id = $data['transaction_id'];
        }
        if (!empty($data['creat_by'])) {
            $Transactionsdetails->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transactionsdetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Transactionsdetails->save();
        $Transactionsdetails = \App\Models\Transactionsdetail::find($Transactionsdetails->id);
        $newCrudData = [];
        $newCrudData['parent'] = $Transactionsdetails->parent;
        $newCrudData['parentId'] = $Transactionsdetails->parentId;
        $newCrudData['transaction_id'] = $Transactionsdetails->transaction_id;
        $newCrudData['creat_by'] = $Transactionsdetails->creat_by;
        $newCrudData['identifiants_sadge'] = $Transactionsdetails->identifiants_sadge;
        try {
            $newCrudData['transaction'] = $Transactionsdetails->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionsdetails', 'entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsdetails->toArray();
        return $data;
    }

}
