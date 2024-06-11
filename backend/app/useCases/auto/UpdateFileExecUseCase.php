<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateFileExecUseCase
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

        $Files = \App\Models\File::find($data['id']);
        $oldFiles = $Files->replicate();

        $oldCrudData = [];
        $oldCrudData['old_name'] = $oldFiles->old_name;
        $oldCrudData['new_name'] = $oldFiles->new_name;
        $oldCrudData['descriptions'] = $oldFiles->descriptions;
        $oldCrudData['extensions'] = $oldFiles->extensions;
        $oldCrudData['size'] = $oldFiles->size;
        $oldCrudData['path'] = $oldFiles->path;
        $oldCrudData['web_path'] = $oldFiles->web_path;
        $oldCrudData['statut'] = $oldFiles->statut;
        $oldCrudData['identifiants_sadge'] = $oldFiles->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldFiles->creat_by;


        if (!empty($data['old_name'])) {
            $Files->old_name = $data['old_name'];
        }
        if (!empty($data['new_name'])) {
            $Files->new_name = $data['new_name'];
        }
        if (!empty($data['descriptions'])) {
            $Files->descriptions = $data['descriptions'];
        }
        if (!empty($data['extensions'])) {
            $Files->extensions = $data['extensions'];
        }
        if (!empty($data['size'])) {
            $Files->size = $data['size'];
        }
        if (!empty($data['path'])) {
            $Files->path = $data['path'];
        }
        if (!empty($data['web_path'])) {
            $Files->web_path = $data['web_path'];
        }
        if (!empty($data['statut'])) {
            $Files->statut = $data['statut'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Files->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Files->creat_by = $data['creat_by'];
        }
        $Files->save();
        $Files = \App\Models\File::find($Files->id);
        $newCrudData = [];
        $newCrudData['old_name'] = $Files->old_name;
        $newCrudData['new_name'] = $Files->new_name;
        $newCrudData['descriptions'] = $Files->descriptions;
        $newCrudData['extensions'] = $Files->extensions;
        $newCrudData['size'] = $Files->size;
        $newCrudData['path'] = $Files->path;
        $newCrudData['web_path'] = $Files->web_path;
        $newCrudData['statut'] = $Files->statut;
        $newCrudData['identifiants_sadge'] = $Files->identifiants_sadge;
        $newCrudData['creat_by'] = $Files->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Files', 'entite_cle' => $Files->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Files->toArray();
        return $data;
    }

}
