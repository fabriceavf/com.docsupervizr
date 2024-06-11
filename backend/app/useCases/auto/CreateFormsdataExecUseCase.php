<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateFormsdataExecUseCase
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

        $Formsdatas = new \App\Models\Formsdata();

        if (!empty($data['libelle'])) {
            $Formsdatas->libelle = $data['libelle'];
        }
        if (!empty($data['parent'])) {
            $Formsdatas->parent = $data['parent'];
        }
        if (!empty($data['form_id'])) {
            $Formsdatas->form_id = $data['form_id'];
        }
        if (!empty($data['cle0'])) {
            $Formsdatas->cle0 = $data['cle0'];
        }
        if (!empty($data['cle1'])) {
            $Formsdatas->cle1 = $data['cle1'];
        }
        if (!empty($data['cle2'])) {
            $Formsdatas->cle2 = $data['cle2'];
        }
        if (!empty($data['cle3'])) {
            $Formsdatas->cle3 = $data['cle3'];
        }
        if (!empty($data['cle4'])) {
            $Formsdatas->cle4 = $data['cle4'];
        }
        if (!empty($data['cle5'])) {
            $Formsdatas->cle5 = $data['cle5'];
        }
        if (!empty($data['cle6'])) {
            $Formsdatas->cle6 = $data['cle6'];
        }
        if (!empty($data['cle7'])) {
            $Formsdatas->cle7 = $data['cle7'];
        }
        if (!empty($data['cle8'])) {
            $Formsdatas->cle8 = $data['cle8'];
        }
        if (!empty($data['cle9'])) {
            $Formsdatas->cle9 = $data['cle9'];
        }
        if (!empty($data['cle10'])) {
            $Formsdatas->cle10 = $data['cle10'];
        }
        if (!empty($data['cle11'])) {
            $Formsdatas->cle11 = $data['cle11'];
        }
        if (!empty($data['cle12'])) {
            $Formsdatas->cle12 = $data['cle12'];
        }
        if (!empty($data['cle13'])) {
            $Formsdatas->cle13 = $data['cle13'];
        }
        if (!empty($data['cle14'])) {
            $Formsdatas->cle14 = $data['cle14'];
        }
        if (!empty($data['cle15'])) {
            $Formsdatas->cle15 = $data['cle15'];
        }
        if (!empty($data['cle16'])) {
            $Formsdatas->cle16 = $data['cle16'];
        }
        if (!empty($data['cle17'])) {
            $Formsdatas->cle17 = $data['cle17'];
        }
        if (!empty($data['cle18'])) {
            $Formsdatas->cle18 = $data['cle18'];
        }
        if (!empty($data['cle19'])) {
            $Formsdatas->cle19 = $data['cle19'];
        }
        if (!empty($data['cle20'])) {
            $Formsdatas->cle20 = $data['cle20'];
        }
        if (!empty($data['cle21'])) {
            $Formsdatas->cle21 = $data['cle21'];
        }
        if (!empty($data['cle22'])) {
            $Formsdatas->cle22 = $data['cle22'];
        }
        if (!empty($data['cle23'])) {
            $Formsdatas->cle23 = $data['cle23'];
        }
        if (!empty($data['cle24'])) {
            $Formsdatas->cle24 = $data['cle24'];
        }
        if (!empty($data['cle25'])) {
            $Formsdatas->cle25 = $data['cle25'];
        }
        if (!empty($data['cle26'])) {
            $Formsdatas->cle26 = $data['cle26'];
        }
        if (!empty($data['cle27'])) {
            $Formsdatas->cle27 = $data['cle27'];
        }
        if (!empty($data['cle28'])) {
            $Formsdatas->cle28 = $data['cle28'];
        }
        if (!empty($data['cle29'])) {
            $Formsdatas->cle29 = $data['cle29'];
        }
        if (!empty($data['cle30'])) {
            $Formsdatas->cle30 = $data['cle30'];
        }
        if (!empty($data['cle31'])) {
            $Formsdatas->cle31 = $data['cle31'];
        }
        if (!empty($data['cle32'])) {
            $Formsdatas->cle32 = $data['cle32'];
        }
        if (!empty($data['cle33'])) {
            $Formsdatas->cle33 = $data['cle33'];
        }
        if (!empty($data['cle34'])) {
            $Formsdatas->cle34 = $data['cle34'];
        }
        if (!empty($data['cle35'])) {
            $Formsdatas->cle35 = $data['cle35'];
        }
        if (!empty($data['cle36'])) {
            $Formsdatas->cle36 = $data['cle36'];
        }
        if (!empty($data['cle37'])) {
            $Formsdatas->cle37 = $data['cle37'];
        }
        if (!empty($data['cle38'])) {
            $Formsdatas->cle38 = $data['cle38'];
        }
        if (!empty($data['cle39'])) {
            $Formsdatas->cle39 = $data['cle39'];
        }
        if (!empty($data['cle40'])) {
            $Formsdatas->cle40 = $data['cle40'];
        }
        if (!empty($data['cle41'])) {
            $Formsdatas->cle41 = $data['cle41'];
        }
        if (!empty($data['cle42'])) {
            $Formsdatas->cle42 = $data['cle42'];
        }
        if (!empty($data['cle43'])) {
            $Formsdatas->cle43 = $data['cle43'];
        }
        if (!empty($data['cle44'])) {
            $Formsdatas->cle44 = $data['cle44'];
        }
        if (!empty($data['cle45'])) {
            $Formsdatas->cle45 = $data['cle45'];
        }
        if (!empty($data['cle46'])) {
            $Formsdatas->cle46 = $data['cle46'];
        }
        if (!empty($data['cle47'])) {
            $Formsdatas->cle47 = $data['cle47'];
        }
        if (!empty($data['cle48'])) {
            $Formsdatas->cle48 = $data['cle48'];
        }
        if (!empty($data['cle49'])) {
            $Formsdatas->cle49 = $data['cle49'];
        }
        if (!empty($data['cle50'])) {
            $Formsdatas->cle50 = $data['cle50'];
        }
        if (!empty($data['cle51'])) {
            $Formsdatas->cle51 = $data['cle51'];
        }
        if (!empty($data['cle52'])) {
            $Formsdatas->cle52 = $data['cle52'];
        }
        if (!empty($data['cle53'])) {
            $Formsdatas->cle53 = $data['cle53'];
        }
        if (!empty($data['cle54'])) {
            $Formsdatas->cle54 = $data['cle54'];
        }
        if (!empty($data['cle55'])) {
            $Formsdatas->cle55 = $data['cle55'];
        }
        if (!empty($data['cle56'])) {
            $Formsdatas->cle56 = $data['cle56'];
        }
        if (!empty($data['cle57'])) {
            $Formsdatas->cle57 = $data['cle57'];
        }
        if (!empty($data['cle58'])) {
            $Formsdatas->cle58 = $data['cle58'];
        }
        if (!empty($data['cle59'])) {
            $Formsdatas->cle59 = $data['cle59'];
        }
        if (!empty($data['cle60'])) {
            $Formsdatas->cle60 = $data['cle60'];
        }
        if (!empty($data['cle61'])) {
            $Formsdatas->cle61 = $data['cle61'];
        }
        if (!empty($data['cle62'])) {
            $Formsdatas->cle62 = $data['cle62'];
        }
        if (!empty($data['cle63'])) {
            $Formsdatas->cle63 = $data['cle63'];
        }
        if (!empty($data['cle64'])) {
            $Formsdatas->cle64 = $data['cle64'];
        }
        if (!empty($data['cle65'])) {
            $Formsdatas->cle65 = $data['cle65'];
        }
        if (!empty($data['cle66'])) {
            $Formsdatas->cle66 = $data['cle66'];
        }
        if (!empty($data['cle67'])) {
            $Formsdatas->cle67 = $data['cle67'];
        }
        if (!empty($data['cle68'])) {
            $Formsdatas->cle68 = $data['cle68'];
        }
        if (!empty($data['cle69'])) {
            $Formsdatas->cle69 = $data['cle69'];
        }
        if (!empty($data['cle70'])) {
            $Formsdatas->cle70 = $data['cle70'];
        }
        if (!empty($data['cle71'])) {
            $Formsdatas->cle71 = $data['cle71'];
        }
        if (!empty($data['cle72'])) {
            $Formsdatas->cle72 = $data['cle72'];
        }
        if (!empty($data['cle73'])) {
            $Formsdatas->cle73 = $data['cle73'];
        }
        if (!empty($data['cle74'])) {
            $Formsdatas->cle74 = $data['cle74'];
        }
        if (!empty($data['cle75'])) {
            $Formsdatas->cle75 = $data['cle75'];
        }
        if (!empty($data['cle76'])) {
            $Formsdatas->cle76 = $data['cle76'];
        }
        if (!empty($data['cle77'])) {
            $Formsdatas->cle77 = $data['cle77'];
        }
        if (!empty($data['cle78'])) {
            $Formsdatas->cle78 = $data['cle78'];
        }
        if (!empty($data['cle79'])) {
            $Formsdatas->cle79 = $data['cle79'];
        }
        if (!empty($data['cle80'])) {
            $Formsdatas->cle80 = $data['cle80'];
        }
        if (!empty($data['cle81'])) {
            $Formsdatas->cle81 = $data['cle81'];
        }
        if (!empty($data['cle82'])) {
            $Formsdatas->cle82 = $data['cle82'];
        }
        if (!empty($data['cle83'])) {
            $Formsdatas->cle83 = $data['cle83'];
        }
        if (!empty($data['cle84'])) {
            $Formsdatas->cle84 = $data['cle84'];
        }
        if (!empty($data['cle85'])) {
            $Formsdatas->cle85 = $data['cle85'];
        }
        if (!empty($data['cle86'])) {
            $Formsdatas->cle86 = $data['cle86'];
        }
        if (!empty($data['cle87'])) {
            $Formsdatas->cle87 = $data['cle87'];
        }
        if (!empty($data['cle88'])) {
            $Formsdatas->cle88 = $data['cle88'];
        }
        if (!empty($data['cle89'])) {
            $Formsdatas->cle89 = $data['cle89'];
        }
        if (!empty($data['cle90'])) {
            $Formsdatas->cle90 = $data['cle90'];
        }
        if (!empty($data['cle91'])) {
            $Formsdatas->cle91 = $data['cle91'];
        }
        if (!empty($data['cle92'])) {
            $Formsdatas->cle92 = $data['cle92'];
        }
        if (!empty($data['cle93'])) {
            $Formsdatas->cle93 = $data['cle93'];
        }
        if (!empty($data['cle94'])) {
            $Formsdatas->cle94 = $data['cle94'];
        }
        if (!empty($data['cle95'])) {
            $Formsdatas->cle95 = $data['cle95'];
        }
        if (!empty($data['cle96'])) {
            $Formsdatas->cle96 = $data['cle96'];
        }
        if (!empty($data['cle97'])) {
            $Formsdatas->cle97 = $data['cle97'];
        }
        if (!empty($data['cle98'])) {
            $Formsdatas->cle98 = $data['cle98'];
        }
        if (!empty($data['cle99'])) {
            $Formsdatas->cle99 = $data['cle99'];
        }
        if (!empty($data['creat_by'])) {
            $Formsdatas->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Formsdatas->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Formsdatas->save();
        $Formsdatas = \App\Models\Formsdata::find($Formsdatas->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Formsdatas', 'entite_cle' => $Formsdatas->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Formsdatas->toArray();
        return $data;
    }

}
