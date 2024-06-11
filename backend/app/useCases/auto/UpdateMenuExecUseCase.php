<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMenuExecUseCase
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
        $oldMenus = $Menus->replicate();

        $oldCrudData = [];
        $oldCrudData['name'] = $oldMenus->name;
        $oldCrudData['icon'] = $oldMenus->icon;
        $oldCrudData['slug'] = $oldMenus->slug;
        $oldCrudData['url'] = $oldMenus->url;
        $oldCrudData['ordre'] = $oldMenus->ordre;
        $oldCrudData['isSu'] = $oldMenus->isSu;
        $oldCrudData['menu_id'] = $oldMenus->menu_id;
        $oldCrudData['entreprise_id'] = $oldMenus->entreprise_id;
        $oldCrudData['creat_by'] = $oldMenus->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldMenus->identifiants_sadge;
        try {
            $oldCrudData['entreprise'] = $oldMenus->entreprise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['menu'] = $oldMenus->menu->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['name'])) {
            $Menus->name = $data['name'];
        }
        if (!empty($data['icon'])) {
            $Menus->icon = $data['icon'];
        }
        if (!empty($data['slug'])) {
            $Menus->slug = $data['slug'];
        }
        if (!empty($data['url'])) {
            $Menus->url = $data['url'];
        }
        if (!empty($data['ordre'])) {
            $Menus->ordre = $data['ordre'];
        }
        if (!empty($data['isSu'])) {
            $Menus->isSu = $data['isSu'];
        }
        if (!empty($data['menu_id'])) {
            $Menus->menu_id = $data['menu_id'];
        }
        if (!empty($data['entreprise_id'])) {
            $Menus->entreprise_id = $data['entreprise_id'];
        }
        if (!empty($data['creat_by'])) {
            $Menus->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Menus->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Menus->save();
        $Menus = \App\Models\Menu::find($Menus->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Menus', 'entite_cle' => $Menus->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Menus->toArray();
        return $data;
    }

}
