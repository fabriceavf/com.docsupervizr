<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionsdetailExecUseCase
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


        $Transactionsdetails->deleted_at = now();
        $Transactionsdetails->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionsdetails', 'entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
