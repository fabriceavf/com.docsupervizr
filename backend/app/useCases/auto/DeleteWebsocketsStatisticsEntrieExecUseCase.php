<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteWebsocketsStatisticsEntrieExecUseCase
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

        $Websockets_statistics_entries = \App\Models\WebsocketsStatisticsEntrie::find($data['id']);


        $Websockets_statistics_entries->deleted_at = now();
        $Websockets_statistics_entries->save();
        $newCrudData = [];
        $newCrudData['app_id'] = $Websockets_statistics_entries->app_id;
        $newCrudData['peak_connection_count'] = $Websockets_statistics_entries->peak_connection_count;
        $newCrudData['websocket_message_count'] = $Websockets_statistics_entries->websocket_message_count;
        $newCrudData['api_message_count'] = $Websockets_statistics_entries->api_message_count;
        $newCrudData['identifiants_sadge'] = $Websockets_statistics_entries->identifiants_sadge;
        $newCrudData['creat_by'] = $Websockets_statistics_entries->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Websockets_statistics_entries', 'entite_cle' => $Websockets_statistics_entries->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
