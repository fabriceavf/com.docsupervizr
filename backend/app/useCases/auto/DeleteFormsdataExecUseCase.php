<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFormsdataExecUseCase
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

        $Formsdatas = \App\Models\Formsdata::find($data['id']);


        $Formsdatas->deleted_at = now();
        $Formsdatas->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Formsdatas->libelle;
        $newCrudData['parent'] = $Formsdatas->parent;
        $newCrudData['form_id'] = $Formsdatas->form_id;
        $newCrudData['cle0'] = $Formsdatas->cle0;
        $newCrudData['cle1'] = $Formsdatas->cle1;
        $newCrudData['cle2'] = $Formsdatas->cle2;
        $newCrudData['cle3'] = $Formsdatas->cle3;
        $newCrudData['cle4'] = $Formsdatas->cle4;
        $newCrudData['cle5'] = $Formsdatas->cle5;
        $newCrudData['cle6'] = $Formsdatas->cle6;
        $newCrudData['cle7'] = $Formsdatas->cle7;
        $newCrudData['cle8'] = $Formsdatas->cle8;
        $newCrudData['cle9'] = $Formsdatas->cle9;
        $newCrudData['cle10'] = $Formsdatas->cle10;
        $newCrudData['cle11'] = $Formsdatas->cle11;
        $newCrudData['cle12'] = $Formsdatas->cle12;
        $newCrudData['cle13'] = $Formsdatas->cle13;
        $newCrudData['cle14'] = $Formsdatas->cle14;
        $newCrudData['cle15'] = $Formsdatas->cle15;
        $newCrudData['cle16'] = $Formsdatas->cle16;
        $newCrudData['cle17'] = $Formsdatas->cle17;
        $newCrudData['cle18'] = $Formsdatas->cle18;
        $newCrudData['cle19'] = $Formsdatas->cle19;
        $newCrudData['cle20'] = $Formsdatas->cle20;
        $newCrudData['cle21'] = $Formsdatas->cle21;
        $newCrudData['cle22'] = $Formsdatas->cle22;
        $newCrudData['cle23'] = $Formsdatas->cle23;
        $newCrudData['cle24'] = $Formsdatas->cle24;
        $newCrudData['cle25'] = $Formsdatas->cle25;
        $newCrudData['cle26'] = $Formsdatas->cle26;
        $newCrudData['cle27'] = $Formsdatas->cle27;
        $newCrudData['cle28'] = $Formsdatas->cle28;
        $newCrudData['cle29'] = $Formsdatas->cle29;
        $newCrudData['cle30'] = $Formsdatas->cle30;
        $newCrudData['cle31'] = $Formsdatas->cle31;
        $newCrudData['cle32'] = $Formsdatas->cle32;
        $newCrudData['cle33'] = $Formsdatas->cle33;
        $newCrudData['cle34'] = $Formsdatas->cle34;
        $newCrudData['cle35'] = $Formsdatas->cle35;
        $newCrudData['cle36'] = $Formsdatas->cle36;
        $newCrudData['cle37'] = $Formsdatas->cle37;
        $newCrudData['cle38'] = $Formsdatas->cle38;
        $newCrudData['cle39'] = $Formsdatas->cle39;
        $newCrudData['cle40'] = $Formsdatas->cle40;
        $newCrudData['cle41'] = $Formsdatas->cle41;
        $newCrudData['cle42'] = $Formsdatas->cle42;
        $newCrudData['cle43'] = $Formsdatas->cle43;
        $newCrudData['cle44'] = $Formsdatas->cle44;
        $newCrudData['cle45'] = $Formsdatas->cle45;
        $newCrudData['cle46'] = $Formsdatas->cle46;
        $newCrudData['cle47'] = $Formsdatas->cle47;
        $newCrudData['cle48'] = $Formsdatas->cle48;
        $newCrudData['cle49'] = $Formsdatas->cle49;
        $newCrudData['cle50'] = $Formsdatas->cle50;
        $newCrudData['cle51'] = $Formsdatas->cle51;
        $newCrudData['cle52'] = $Formsdatas->cle52;
        $newCrudData['cle53'] = $Formsdatas->cle53;
        $newCrudData['cle54'] = $Formsdatas->cle54;
        $newCrudData['cle55'] = $Formsdatas->cle55;
        $newCrudData['cle56'] = $Formsdatas->cle56;
        $newCrudData['cle57'] = $Formsdatas->cle57;
        $newCrudData['cle58'] = $Formsdatas->cle58;
        $newCrudData['cle59'] = $Formsdatas->cle59;
        $newCrudData['cle60'] = $Formsdatas->cle60;
        $newCrudData['cle61'] = $Formsdatas->cle61;
        $newCrudData['cle62'] = $Formsdatas->cle62;
        $newCrudData['cle63'] = $Formsdatas->cle63;
        $newCrudData['cle64'] = $Formsdatas->cle64;
        $newCrudData['cle65'] = $Formsdatas->cle65;
        $newCrudData['cle66'] = $Formsdatas->cle66;
        $newCrudData['cle67'] = $Formsdatas->cle67;
        $newCrudData['cle68'] = $Formsdatas->cle68;
        $newCrudData['cle69'] = $Formsdatas->cle69;
        $newCrudData['cle70'] = $Formsdatas->cle70;
        $newCrudData['cle71'] = $Formsdatas->cle71;
        $newCrudData['cle72'] = $Formsdatas->cle72;
        $newCrudData['cle73'] = $Formsdatas->cle73;
        $newCrudData['cle74'] = $Formsdatas->cle74;
        $newCrudData['cle75'] = $Formsdatas->cle75;
        $newCrudData['cle76'] = $Formsdatas->cle76;
        $newCrudData['cle77'] = $Formsdatas->cle77;
        $newCrudData['cle78'] = $Formsdatas->cle78;
        $newCrudData['cle79'] = $Formsdatas->cle79;
        $newCrudData['cle80'] = $Formsdatas->cle80;
        $newCrudData['cle81'] = $Formsdatas->cle81;
        $newCrudData['cle82'] = $Formsdatas->cle82;
        $newCrudData['cle83'] = $Formsdatas->cle83;
        $newCrudData['cle84'] = $Formsdatas->cle84;
        $newCrudData['cle85'] = $Formsdatas->cle85;
        $newCrudData['cle86'] = $Formsdatas->cle86;
        $newCrudData['cle87'] = $Formsdatas->cle87;
        $newCrudData['cle88'] = $Formsdatas->cle88;
        $newCrudData['cle89'] = $Formsdatas->cle89;
        $newCrudData['cle90'] = $Formsdatas->cle90;
        $newCrudData['cle91'] = $Formsdatas->cle91;
        $newCrudData['cle92'] = $Formsdatas->cle92;
        $newCrudData['cle93'] = $Formsdatas->cle93;
        $newCrudData['cle94'] = $Formsdatas->cle94;
        $newCrudData['cle95'] = $Formsdatas->cle95;
        $newCrudData['cle96'] = $Formsdatas->cle96;
        $newCrudData['cle97'] = $Formsdatas->cle97;
        $newCrudData['cle98'] = $Formsdatas->cle98;
        $newCrudData['cle99'] = $Formsdatas->cle99;
        $newCrudData['creat_by'] = $Formsdatas->creat_by;
        $newCrudData['identifiants_sadge'] = $Formsdatas->identifiants_sadge;
        try {
            $newCrudData['form'] = $Formsdatas->form->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Formsdatas', 'entite_cle' => $Formsdatas->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
