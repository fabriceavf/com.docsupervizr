<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionsdetailExecUseCase
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

        $Transactionsdetails = new \App\Models\Transactionsdetail();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionsdetails', 'entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsdetails->toArray();
        return $data;
    }

}
