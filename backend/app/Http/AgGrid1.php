<?php

namespace App\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgGrid1
{
    private $table;
    private $model;
    private $filterOperator = [];

    public function __construct($table, $model)
    {
        $this->table = $table;
        $this->model = $model;
        $this->initFilter();


    }

    private function initFilter()
    {

        $this->filterOperator['set'] = function ($champs, $value) {
//            dd($champs,$value);
            return $champs . ' IN ("' . join('", "', $value) . '")';
        };
        $this->filterOperator['equals'] = function ($champs, $value) {
            return $champs . ' = ' . $value;
        };
        $this->filterOperator['notEquals'] = function ($champs, $value) {
            return $champs . ' <> ' . $value;
        };
        $this->filterOperator['contains'] = function ($champs, $value) {
            return $champs . ' LIKE ' . "'%" . $value . "%'";
        };
        $this->filterOperator['notContains'] = function ($champs, $value) {
            return $champs . ' NOT LIKE ' . "'%" . $value . "%'";
        };
        $this->filterOperator['contains'] = function ($champs, $value) {
            return $champs . ' LIKE ' . "'%" . $value . "%'";
        };
        $this->filterOperator['startsWith'] = function ($champs, $value) {
            return $champs . ' LIKE ' . "'" . $value . "%'";
        };

        $this->filterOperator['endsWith'] = function ($champs, $value) {
            return $champs . ' LIKE ' . "'%" . $value . "'";
        };
        $this->filterOperator['blank'] = function ($champs, $value) {
            return $champs . ' IS NULL';
        };
        $this->filterOperator['notBlank'] = function ($champs, $value) {
            return $champs . ' IS NOT NULL';
        };

    }

    public function getSetFilterValues(Request $request, $field)
    {
        $values = DB::table("$this->table")->select($field)->distinct()->orderBy($field, 'asc')->pluck($field);
        return $values;
    }

    public function getData(Request $request)
    {
        $SQL = $this->buildSql($request);
        // for debugging purposes - logs are saved to storage/logs/laravel.log
        Log::debug($SQL);

        $results = DB::select($SQL);
        $data = $results;
        $new = [];
        foreach ($results as $resul) {
            $new[] = $resul->id;
        }
        Log::debug(implode(',', $new));
        $data = $this->model::findMany($new);
        $data = $data->sortBy(function ($product, $key) use ($new) {
//            dd($product,$new);
            return array_search($product->id, $new);
        })->values();

        $rowCount = $this->getRowCount($request, $results);
        $resultsForPage = $this->cutResultsToPageSize($request, $results);

        $SQL2 = $this->buildSqlForLast($request);
        Log::debug($SQL2);
        $results = DB::select($SQL2);


        return [
            'rowData' => $data,
            'rowCount' => $results[0]->total,
            'lastRowIndex' => 0
        ];
    }

    public function buildSql(Request $request)
    {
        $selectSql = $this->createSelectSql($request);
        $fromSql = " FROM $this->table ";
        $whereSql = $this->whereSql($request);
        $groupBySql = $this->groupBySql($request);
        $orderBySql = $this->orderBySql($request);
        $limitSql = $this->createLimitSql($request);

        $SQL = $selectSql . $fromSql . $whereSql . $groupBySql . $orderBySql . $limitSql;
//        dump ($SQL);
        return $SQL;
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

    public function whereSql(Request $request)
    {
        $rowGroupCols = $request->input('rowGroupCols');
        $groupKeys = $request->input('groupKeys');
        $filterModel = $request->input('filterModel');
//        dd($filterModel);

        $whereParts = [];

        if (sizeof($groupKeys) > 0) {
            foreach ($groupKeys as $key => $value) {
                $colName = $rowGroupCols[$key]['field'];
                array_push($whereParts, "{$colName} = '{$value}'");
            }
        }
        $conditions = [];


        if ($filterModel) {

            foreach ($filterModel as $name => $data) {

//                dd($data);
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

                }
                if (!empty($value['type']) && !empty($value['filter'])) {
                    $_condition[] = [
                        'type' => $value['type'],
                        'value' => $value['filter'] ?? "",

                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => "",
                        'fields' => $_condition
                    ];
                }
                if (!empty($value['filterType']) && $value['filterType'] == "set") {
                    $_condition[] = [
                        'type' => $value['filterType'],
                        'value' => $value['values'] ?? [],

                    ];
                    $conditions[] = [
                        'champ' => $name,
                        'operator' => "",
                        'fields' => $_condition
                    ];
                }


//                dd($where);

//                if($value['filterType']=='text' && $value['type']=='equals'){
//                    array_push($whereParts, $key . ' " ("'  . join('", "', $value['values']) . '")');
//                }
//                if ($value['filterType'] == 'set') {
//                    array_push($whereParts, $key . ' IN ("'  . join('", "', $value['values']) . '")');
//                }
            }
            $deleted_at_condition = [];
            $deleted_at_condition[] = [
                'type' => 'blank',
                'value' => '',

            ];
            $conditions[] = [
                'champ' => 'deleted_at',
                'operator' => "",
                'fields' => $deleted_at_condition
            ];
        }

//        dd($conditions);
        foreach ($conditions as $whereCondition) {
            $whereParts[] = $this->traiteWhereCondition($whereCondition);

        }
        $where = "";

        if (sizeof($whereParts) > 0) {
            $where = " WHERE " . join(' and ', $whereParts);
        } else {
            $where = "";
        }
//        dd($where);

        return $where;
    }

    public function traiteWhereCondition($condition)
    {
//     dd($condition);
        $where = [];
        foreach ($condition['fields'] as $champs) {
            $where[] = " " . $this->filterOperator[$champs['type']]($condition['champ'], $champs['value']) . " ";
        }
        $where = implode($condition['operator'], $where);
        return '( ' . $where . ' )';

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
        $sortModel = $request->input('sortModel');

        if ($sortModel) {
            $sortParts = [];

            foreach ($sortModel as $key => $value) {
                array_push($sortParts, $value['colId'] . " " . $value['sort']);
            }

            if (sizeof($sortParts) > 0) {
                return " ORDER BY " . join(", ", $sortParts);
            } else {
                return '';
            }
        }
    }

    public function createLimitSql(Request $request)
    {
        $startRow = $request->input('startRow');
        $endRow = $request->input('endRow');
        $pageSize = ($endRow - $startRow) + 1;

        return " LIMIT {$pageSize} OFFSET {$startRow};";
    }

    public function getRowCount($request, $results)
    {
        if (is_null($results) || !isset($results) || sizeof($results) == 0) {
            // or return null
            return 0;
        }

        $currentLastRow = $request['startRow'] + sizeof($results);

        if ($currentLastRow <= $request['endRow']) {
            return $currentLastRow;
        } else {
            return -1;
        }
    }

    public function cutResultsToPageSize($request, $results)
    {
        $pageSize = $request['endRow'] - $request['startRow'];

        if ($results && (sizeof($results) > $pageSize)) {
            return array_splice($results, 0, $pageSize);
        } else {
            return $results;
        }
    }

    public function buildSqlForLast(Request $request)
    {
        $selectSql = "SELECT COUNT(id) AS total";
        $fromSql = " FROM $this->table ";
        $whereSql = $this->whereSql($request);
        $groupBySql = $this->groupBySql($request);
        $orderBySql = $this->orderBySql($request);

        $SQL = $selectSql . $fromSql . $whereSql . $groupBySql . $orderBySql;
        return $SQL;
    }

}
