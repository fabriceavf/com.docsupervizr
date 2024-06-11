<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AggridMenuExecUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {
        $agGrid = new \App\Http\AgGrid('menus', $data['__query__']);
        $newData = [];
        $action = 'read';
        $startRow = 0;
        $endRow = 100;
        $sortModel = [];
        $rowGroupCols = [];
        $groupKeys = [];
        $filterModel = [];
        $filterModelGlobal = [];
        $cles = ['newData', 'action', 'startRow', 'endRow', 'sortModel', 'rowGroupCols', 'groupKeys', 'filterModel', 'filterModelGlobal'];
        foreach ($cles as $cle) {
            if (!empty($data) && is_array($data) and array_key_exists($cle, $data)) {
                $$cle = $data[$cle];
            }
        }

        $getId = false;
        $getQuery = false;
        $getFilter = false;
        $showDelete = false;
        try {
            $getId = $data['__extras__']['selectAllId'];
        } catch (\Throwable $e) {
        }
        try {
            $getQuery = $data['__extras__']['selectAllQuery'];
        } catch (\Throwable $e) {
        }
        try {
            $getFilter = $data['__extras__']['selectAllFilter'];
        } catch (\Throwable $e) {
        }
        if (!empty($data['__showDelete__'])) {
            $showDelete = $data['__showDelete__'];
        }
        $agGrid->whereSql($filterModel, $filterModelGlobal, $showDelete);
        $data['__result__'] = $agGrid->getData($startRow, $endRow, $sortModel, $getId, $getQuery, $getFilter);
        $userAgent = '';
        if (
            is_array($data) && array_key_exists('__headers__', $data)
            && is_array($data['__headers__']) && array_key_exists('user-agent', $data['__headers__'])
            && is_array($data['__headers__']['user-agent']) && count($data['__headers__']['user-agent']) > 0
        ) {
            $userAgent = $data['__headers__']['user-agent'][0];
        }
        try {
            \Illuminate\Support\Facades\DB::table('logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'Lectures des donnees api de  menus reussi',
                'ip' => 'Non defini',
                'pays' => 'Non defini',
                'ville' => 'Non defini',
                'navigateur' => $userAgent,
                'created_at' => now(),
            ]);

        } catch (\Throwable) {
        }
        return $data;


    }

}
