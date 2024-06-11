<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AgGrid
{
    private $table;
    private $model;
    private $showDelete = false;
    private $filterOperator = [];

    public function __construct($table, Builder $model)
    {
        $this->table = $table;
        $this->model = $model;

        $this->initFilter();
    }

    private function initFilter()
    {

        $this->filterOperator['set'] = function ($champs, $value, Builder $query, $operator) {
            //            dd($champs,$value);
            $operator = strtolower($operator);
            if ($operator == "" || $operator == "and") {
                $query->whereIn($champs, $value);
            } else {
                $query->orWhereIn($champs, $value);
            }
        };
        $this->filterOperator['equals'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['notEquals'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['contains'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['notContains'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['startsWith'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['endsWith'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            $value = "%" . $value . "%";
            if ($operator == "" || $operator == "and") {
                $query->where($champs, "LIKE", $value);
            } else {
                $query->orWhere($champs, "LIKE", $value);
            }
        };
        $this->filterOperator['blank'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            if ($operator == "" || $operator == "and") {
                $query->whereNull($champs);
            } else {
                $query->orWhereNull($champs);
            }
        };
        $this->filterOperator['notBlank'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            if ($operator == "" || $operator == "and") {
                $query->whereNotNull($champs);
            } else {
                $query->orWhereNotNull($champs);
            }
        };
        $this->filterOperator['superieur'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            if ($operator == "" || $operator == "and") {
                $query->where($champs, '>', $value);
            } else {
                $query->orWhere($champs, '>', $value);
            }
        };
        $this->filterOperator['inferieur'] = function ($champs, $value, Builder $query, $operator) {
            $operator = strtolower($operator);
            if ($operator == "" || $operator == "and") {
                $query->where($champs, '<', $value);
            } else {
                $query->orWhere($champs, '<', $value);
            }
        };

    }

    public function getData(Request $request)
    {

        if (!empty($request->has('__showDelete__'))) {
            $this->showDelete = $request->get('__showDelete__');
        }

        Log::debug($request->all());
        $this->whereSql($request);
        $this->groupBySql($request);
        $this->orderBySql($request);


        //        je doit mettre en cache cette reponse
        $allId = [];
        $allFilters = [];
        $query = "";
        $bidings = [];
        $getId = false;
        $getQuery = false;
        $getFilter = false;
        try {
            $getId = $request->get('__extras__')['selectAllId'];
        } catch (Throwable $e) {
        }
        try {
            $getQuery = $request->get('__extras__')['selectAllQuery'];
        } catch (Throwable $e) {
        }
        try {
            $getFilter = $request->get('__extras__')['selectAllFilter'];
        } catch (Throwable $e) {
        }
        if ($getId) {
            $allId = $this->model->select('id')->get()->pluck('id');
        }
        if ($getQuery) {
            $query = $this->model->select('id')->toSql();
            $bidings = $this->model->getBindings();
        }
        if ($getFilter) {
            $allFilters = $request->get('filterModel');
        }
        $this->model->select('*');


        Log::debug('requette sans limit ==>' . $this->model->toSql());

        $totalDataWithoutLimit = $this->model->count();

        $this->createLimitSql($request);
        Log::debug('requette complete==>' . $this->model->toSql());
        $data = $this->model->orderBy($this->table . '.created_at')->get();


        return [
            'rowData' => $data,
            'rowCount' => $totalDataWithoutLimit,
            '__allId' => $allId,
            '__allFilters' => $allFilters,
            '__allQuery' => $query,
            '__allQueryBindings' => $bidings,
            'startRow' => $request->get('startRow'),
            'endRow' => $request->get('endRow'),
        ];
    }

    public function whereSql(Request $request)
    {
        $rowGroupCols = $request->input('rowGroupCols');
        $groupKeys = $request->input('groupKeys');
        $filterModel = $request->input('filterModel');
        $filterModelGlobal = $request->input('filterModelGlobal');

        if (!empty($filterModelGlobal) && is_array($filterModelGlobal)) {

        } else {
            $filterModelGlobal = [];
        }
        //        dd($filterModel);

        $whereParts = [];
        $conditions = [];
        if ($filterModel) {
            foreach ($filterModel as $name => $data) {
                $_condition = [];
                $value = $data;
                if (!empty($value['condition1']) && !empty($value['condition2'])) {

                    $_condition[] = [
                        'type' => $value['condition1']['type'],
                        'value' => $value['condition1']['filter'] ?? '',
                    ];
                    $_condition[] = [
                        'type' => $value['condition2']['type'],
                        'value' => $value['condition2']['filter'] ?? "",
                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => $value['operator'],
                        'fields' => $_condition
                    ];
                } else if (!empty($value['type']) && (!empty($value['filter']))) {
                    $_condition[] = [
                        'type' => $value['type'],
                        'value' => $value['filter'] ?? "",

                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => "",
                        'fields' => $_condition
                    ];
                } else if (!empty($value['filterType']) && $value['filterType'] == "set") {
                    $_condition[] = [
                        'type' => $value['filterType'],
                        'value' => $value['values'] ?? [],

                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => "",
                        'fields' => $_condition
                    ];
                } else if (!empty($value['filterType']) && !empty($value['type']) && $value['filterType'] == "text") {
                    $_condition[] = [
                        'type' => $value['type'],
                        'value' => $value['values'] ?? [],

                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => "",
                        'fields' => $_condition
                    ];
                }

            }
        }
        $deleted_at_condition = [];
        $deleted_at_condition[] = [
            'type' => $this->showDelete ? 'notBlank' : 'blank',
            'value' => '',

        ];
        $conditions[] = [
            'champ' => $this->table . '.deleted_at',
            'operator' => "",
            'fields' => $deleted_at_condition
        ];

        $globalConditions = [];

        foreach ($conditions as $whereCondition) {
            foreach ($whereCondition['fields'] as $champs) {
                $_dat = [
                    'type' => $champs['type'],
                    'champ' => $whereCondition['champ'],
                    'value' => $champs['value'],
                ];
                $globalConditions[] = $_dat;
            }
        }

        foreach ($filterModelGlobal as $whereCondition) {
            $_dat = [
                'type' => $whereCondition['type'],
                'champ' => $whereCondition['champ'],
                'value' => $whereCondition['value']
            ];
            $globalConditions[] = $_dat;
        }
//        dd($globalConditions);
        foreach ($globalConditions as $whereCondition) {
//            dd($whereCondition);
            $this->model
                ->where(function (Builder $q) use ($whereCondition) {
                    $this->filterOperator[$whereCondition['type']]($whereCondition['champ'], $whereCondition['value'], $q, "");

                });
        }
    }

    public function groupBySql(Request $request)
    {

        $rowGroupCols = $request->input('rowGroupCols');
        $groupKeys = $request->input('groupKeys');

        if ($this->isDoingGrouping($rowGroupCols, $groupKeys)) {
            $colsToGroupBy = [];

            $rowGroupCol = $rowGroupCols[sizeof($groupKeys)];
            array_push($colsToGroupBy, $rowGroupCol['field']);

            return " GROUP BY " . join(", ", $colsToGroupBy);
        } else {
            // select all columns
            return "";
        }
    }

    public function isDoingGrouping($rowGroupCols, $groupKeys)
    {
        // we are not doing grouping if at the lowest level. we are at the lowest level
        // if we are grouping by more columns than we have keys for (that means the user
        // has not expanded a lowest level group, OR we are not grouping at all).

        return sizeof($rowGroupCols) > sizeof($groupKeys);
    }

    public function orderBySql(Request $request)
    {
        $modelInstance = $this->model->getModel(); // Obtenez une instance du modèle
        $tableName = $modelInstance->getTable(); // Obtenez le nom de la table
        $sortModel = $request->input('sortModel');
        if ($sortModel) {
            $sortParts = [];
            foreach ($sortModel as $key => $value) {
                $sortParts[$value['colId']] = $value['sort'];
            }

            foreach ($sortParts as $champ => $type) {
                $this->model->orderBy($champ, $type);
            }
        }

        $this->model->orderBy('created_at', 'DESC');
    }

    public function createLimitSql(Request $request)
    {
        $startRow = $request->input('startRow');
        $endRow = $request->input('endRow');
        $pageSize = ($endRow - $startRow) + 1;

        $this->model
            ->offset($startRow)
            ->limit($pageSize);
    }

    public function createSelectSql(Request $request)
    {
        $rowGroupCols = $request->input('rowGroupCols');
        $valueCols = $request->input('valueCols');
        $groupKeys = $request->input('groupKeys');

        //        if ($this->isDoingGrouping($rowGroupCols, $groupKeys)) {
        //            $colsToSelect = [];
        //
        //            $rowGroupCol = $rowGroupCols[sizeof($groupKeys)];
        //            array_push($colsToSelect, $rowGroupCol['field']);
        //
        //            foreach ($valueCols as $key => $value) {
        //                array_push($colsToSelect, $value['aggFunc'] . '(' . $value['field'] . ') as ' . $value['field']);
        //            }
        //
        //            return "SELECT " . join(", ", $colsToSelect);
        //        }

        return "SELECT * ";
    }
}
