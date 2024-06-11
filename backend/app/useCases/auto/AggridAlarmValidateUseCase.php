<?php

namespace App\useCases\auto;

use Illuminate\Database\Eloquent\SoftDeletingScope;

class AggridAlarmValidateUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

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
        $extras = [];
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
        if (!empty($data['__extras__'])) {
            $extras = $data['__extras__'];
        }

        if (!empty($extras['baseFilter']) && is_array($extras['baseFilter'])) {
            $oldFilter = $filterModel;
            $newFilter = array_merge($oldFilter, $extras['baseFilter']);
            $filterModel = $newFilter;
        }

        $query = \App\Models\Alarm::withoutGlobalScope(SoftDeletingScope::class);


        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                };

            });


        }
        $data['__query__'] = $query;
        $data['filterModel'] = $filterModel;
        return $data;
    }


}
