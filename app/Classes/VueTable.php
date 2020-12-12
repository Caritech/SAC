<?php

namespace App\Classes;

use Illuminate\Http\Request;
use DB;

class VueTable
{
    /*
    Composite Function for Vuetable
    filter
    sort
    paginate
     */
    public static function fetch($query, Request $request, $parameter = [])
    {

        $query = VueTable::filter($query, $request, $parameter);
        $query = VueTable::sort($query, $request, $parameter);
        $result = VueTable::paginate($query, $request);
        return $result;
    }

    /*
        Using search parameter from url
        *** FOR SIMPLE SEARCH
        *** REQUIRED Declare searchable column
        example: (Please using raw sql instead of alias)
            $searchable_column = [
                sql_pp_name_with_no('pp_c', 'c.customer_no'),
                sql_pp_name_with_no('pp_w', 'w.sw_no'),
                'ss.code'
            ];
        * param => searchable_column use for simple search
        * declare the columns that can be searched usign
     */
    public static function filter($query, Request $request, $parameter = [])
    {
        $search = $request->input('search');
        $search_mode = $request->input('search_mode') ?? 'advance';
        $searchable_column = $parameter['searchable_column'] ?? [];

        /*
            Simple Search using subquery
        */
        if ($search_mode == 'simple') {

            $search_text = $request->input('search_text') ?? '';
            $query->where(function ($w) use ($searchable_column, $search_text) {
                foreach ($searchable_column as $col) {
                    $w->orWhere(DB::raw($col), 'like', "%$search_text%");
                }
            });
        } else {

            if (!is_array($search)) {
                return $query;
            }


            foreach ($search as $s) {

                $arr = json_decode($s, true);
                if ($arr == []) {
                    continue;
                }
                $prefix = $arr['prefix'] ?? ''; // table alias
                $column = $arr['column'];

                $selected_type = $arr['filter_type'];
                $whereHaving = $arr['sql_type'] ?? 'where'; // where OR having

                if ($prefix != '' && $whereHaving != 'having') {
                    $column = $prefix . '.' . $column;
                }

                //having only workable for contains filter type
                if ($whereHaving == 'having') {
                    if (in_array($selected_type, ['in', 'not_in', 'between', 'not_between', 'null_or_empty', 'not_null'])) {
                        //SKIP search
                        continue;
                    }
                }
                $value = $arr['value'] ?? null;
                $value2 = $arr['value2'] ?? null;
                if ($value == null && !in_array($selected_type, ['null_or_empty', 'not_null'])) {
                    continue;
                }

                //IF Column's made up sql is provided in searchable column, using where and that made up sql 
                if ($whereHaving == 'having' && isset($searchable_column[$column])) {
                    $whereHaving = 'where';
                    $column = DB::raw($searchable_column[$column]);
                }

                //dd($query->where($column, '8003')->get());

                if ($selected_type == 'equal') {
                    $query->$whereHaving($column, $value);
                } elseif ($selected_type == 'not_equal') {
                    $query->$whereHaving($column, '!=', $value);
                } elseif ($selected_type == 'like') {
                    $query->$whereHaving($column, 'LIKE', "%$value%");
                } elseif ($selected_type == 'not_like') {
                    $query->$whereHaving($column, 'NOT LIKE', "%$value%");
                } elseif ($selected_type == 'in') {
                    $query->whereIn($column, $value);
                } elseif ($selected_type == 'not_in') {
                    $query->whereNotIn($column, $value);
                } elseif ($selected_type == 'between') {
                    $query->whereBetween($column, [$value, $value2]);
                } elseif ($selected_type == 'not_between') {
                    $query->whereNotBetween($column, [$value, $value2]);
                } elseif ($selected_type == 'more_than') {
                    $query->where($column, '>', $value);
                } elseif ($selected_type == 'less_than') {
                    $query->where($column, '<', $value);
                } elseif ($selected_type == 'null_or_empty') {
                    $query->where(function ($w) use ($column) {
                        $w->whereNull($column);
                        $w->orWhere($column, '');
                    });
                } elseif ($selected_type == 'not_null') {
                    $query->where(function ($w) use ($column) {
                        $w->whereNotNull($column);
                        $w->Where($column, '!=', '');
                    });
                }
            } //end of foreach search
        }

        return $query;
    }

    /*
    Using sort parameter from url
     */
    public static function sort($query, Request $request, $parameter = [])
    {
        $default_sort = $parameter['default_sort'] ?? [];
        $sort = $request->input('sort');

        if ($sort != null) {
            if (strpos($sort, '|') !== false) {
                list($col, $order) = explode('|', $sort);
                $query->orderBy($col, $order);
            }
        } else {
            foreach ($default_sort as $col => $sorting) {
                $query->orderBy($col, $sorting);
            }
        }
        return $query;
    }

    /*
    Using per_page parameter from url
     */
    public static function paginate($query, Request $request)
    {
        $per_page = $request->input('per_page');

        if ($per_page != null) {
            $query = $query->paginate($per_page);
        } else {
            $query = $query->get();
        }
        return $query;
    }

    public static function generateUrlForVueTableSearch($url, $arr)
    {
        //convert to url param
        $arr_params = [];
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $v = json_encode($v);
            }
            $arr_params[] = "$k=$v";
        }
        $json = implode('&', $arr_params);
        $url = $url . '?' . $json;
        return $url;
    }
}
