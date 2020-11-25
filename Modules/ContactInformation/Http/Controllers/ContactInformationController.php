<?php

namespace Modules\ContactInformation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactInformation\Entities\SupportWorker;

class ContactInformationController extends Controller
{
    public function get_support_worker_lists(Request $request)
    {
        $post = $request->input();

        $support_worker_lists = SupportWorker::join('personal_particular', 'personal_particular.id', '=', 'support_worker.pp_id');
        $search = $post['search'] ?? [];

        foreach ($search as $s) {
            $arr = json_decode($s, true);
            if ($arr == []) {
                continue;
            }

            $column = $arr['column'];
            $selected_type = $arr['filter_type'];
            $value = $arr['value'] ?? null;
            $value2 = $arr['value2'] ?? null;
            if ($value == null) {
                continue;
            }
            if ($selected_type == 'equal') {
                $support_worker_lists->where($column, $value);
            } elseif ($selected_type == 'not_equal') {
                $support_worker_lists->where($column, '!=', $value);
            } elseif ($selected_type == 'like') {
                $support_worker_lists->where($column, 'LIKE', "%$value%");
            } elseif ($selected_type == 'not_like') {
                $support_worker_lists->where($column, 'NOT LIKE', "%$value%");
            } elseif ($selected_type == 'in') {
                $support_worker_lists->whereIn($column, $value);
            } elseif ($selected_type == 'not_in') {
                $support_worker_lists->whereNotIn($column, $value);
            } elseif ($selected_type == 'between') {
                $support_worker_lists->whereBetween($column, $value);
            } elseif ($selected_type == 'not_between') {
                $support_worker_lists->whereNotBetween($column, $value);
            } elseif ($selected_type == 'more_than') {
                $support_worker_lists->where($column, '>', $value);
            } elseif ($selected_type == 'less_than') {
                $support_worker_lists->where($column, '<', $value);
            } elseif ($selected_type == 'null_or_empty') {
                $support_worker_lists->where(function ($w) use ($column) {
                    $w->whereNull($column);
                    $w->orWhere($column, '');
                });
            } elseif ($selected_type == 'not_null') {
                $support_worker_lists->where(function ($w) use ($column) {
                    $w->whereNotNull($column);
                    $w->Where($column, '!=', '');
                });
            }

            //
        }
        //dd($support_worker_lists->get());
        //dd($search);
        //dd($post);

        //$support_worker_lists-

        if (isset($post['sort'])) {
            $sort = $post['sort'];
            if (strpos($sort, '|') !== false) {
                list($col, $order) = explode('|', $sort);
                $support_worker_lists->orderBy($col, $order);
            }
        }

        if (isset($post['per_page'])) {
            $support_worker_lists = $support_worker_lists->paginate($post['per_page']);
        } else {
            $support_worker_lists = $support_worker_lists->get();
        }
        return $support_worker_lists;
    }
}
