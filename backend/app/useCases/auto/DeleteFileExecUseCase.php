<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFileExecUseCase
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


        $Files->deleted_at = now();
        $Files->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Files', 'entite_cle' => $Files->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
