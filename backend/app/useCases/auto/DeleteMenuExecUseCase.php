<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMenuExecUseCase
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

        $Menus = \App\Models\Menu::find($data['id']);


        $Menus->deleted_at = now();
        $Menus->save();
        $newCrudData = [];
        $newCrudData['name'] = $Menus->name;
        $newCrudData['icon'] = $Menus->icon;
        $newCrudData['slug'] = $Menus->slug;
        $newCrudData['url'] = $Menus->url;
        $newCrudData['ordre'] = $Menus->ordre;
        $newCrudData['isSu'] = $Menus->isSu;
        $newCrudData['menu_id'] = $Menus->menu_id;
        $newCrudData['entreprise_id'] = $Menus->entreprise_id;
        $newCrudData['creat_by'] = $Menus->creat_by;
        $newCrudData['identifiants_sadge'] = $Menus->identifiants_sadge;
        try {
            $newCrudData['entreprise'] = $Menus->entreprise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['menu'] = $Menus->menu->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Menus', 'entite_cle' => $Menus->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
