<?php

namespace Modules\Scheduler\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Scheduler\Entities\ServiceAgreement;
use Validator;

//use Modules\Scheduler\Traits\ServiceTraits;

class ServiceAgreementController extends Controller
{
    //use ServiceTraits;
    public function __construct()
    {$this->middleware('auth');}

    public function get_service_agreement_lists(Request $request)
    {
        $post = $request->input();
        $client_id = $request->client_id ?? null;

        $lists = DB::table('service_agreement AS sa');
        $lists->SelectRaw('
            sa.*,
            TRIM(REPLACE(
                CONCAT_WS(" ",COALESCE(pd.LegacyProviderNo, ""),COALESCE(pd.PreferName, ""), COALESCE(pd.FirstName, ""),
                                COALESCE(pd.MiddleName, ""), COALESCE(pd.Surname, "") ), "  ", " "
            )) AS client_name,
            ss.code AS service_code
        ');
        $lists->leftJoin('setting_services AS ss', 'ss.id', 'sa.service_id');
        $lists->leftJoin('personal_details AS pd', 'pd.id', 'sa.client');

        if ($client_id != null) {
            $lists->where('client', $client_id);
        }

        if (isset($post['sort'])) {
            $sort = $post['sort'];
            if (strpos($sort, '|') !== false) {
                list($col, $order) = explode('|', $sort);
                $lists->orderBy($col, $order);
            }
        }

        if (isset($post['per_page'])) {
            $lists = $lists->paginate($post['per_page']);
        } else {
            $lists = $lists->get();
        }

        return $lists;
    }

    public function get_service_agreement_dropdown(Request $request)
    {
        $lists_service = DB::table('setting_services')->get();

        $lists_client = DB::table('personal_details_customer AS c');
        $lists_client->join('personal_details AS pd', 'pd.id', '=', 'c.pd_id');
        $lists_client->groupBy('c.pd_id');
        $lists_client->SelectRaw('
            c.pd_id AS `key`,
            TRIM(REPLACE(
                CONCAT_WS(" ",COALESCE(pd.LegacyProviderNo, ""),COALESCE(pd.PreferName, ""), COALESCE(pd.FirstName, ""),
                                COALESCE(pd.MiddleName, ""), COALESCE(pd.Surname, "") ), "  ", " "
            )) AS label
        ');
        $lists_client = $lists_client->get();

        $lists_level = range(0, 4);

        return [
            'lists_service' => $lists_service,
            'lists_client' => $lists_client,
            'lists_level' => $lists_level,
        ];
    }

    public function get_client_info(Request $request, $client_id = null)
    {
        if ($client_id == null) {
            $client_id = $request->input('client_id');
        }

        $data = DB::table('personal_details AS pd')
            ->selectRaw('
              ' . sqlPDName('pd') . ' AS name,
              pd.Gender AS gender,
              pd.DOB AS dob,
              pdc.LegacyCustomerNo AS client_no,
              pd.id
            ')
            ->where('pd.id', $client_id)
            ->leftJoin('personal_details_customer AS pdc', 'pdc.pd_id', '=', 'pd.id')
            ->first();
        return (array) $data;
    }

    public function get_agreement_detail(Request $request)
    {
        $agreement_id = $request->input('agreement_id');
        $data = ServiceAgreement::findOrFail($agreement_id);
        return $data;
    }

    public function save_service_agreement(Request $request)
    {
        $post = $request->input();
        $agreement = $post['agreement'];
        $agreement_id = $agreement['id'] ?? null;

        if ($agreement_id != null) {
            $validator = Validator::make($agreement, ServiceAgreement::updateRules());
        } else {
            $validator = Validator::make($agreement, ServiceAgreement::createRules());
        }
        if ($validator->fails()) {
            $error_msg = covert_validation_errror_to_html($validator);
            return ['errors' => $validator->errors(), 'error_message' => $error_msg];
        }

        if ($agreement_id != null) {
            $agreement = ServiceAgreement::find($agreement_id)->fill($agreement)->save();
        } else {
            $agreement = ServiceAgreement::create($agreement);
        }
        return $agreement;
    }

    //id = agreement id
    public function budgetplan($agreement_id)
    {
        return view('service.agreement.budgetplan', compact('agreement_id'));
    }

    public function axios_get_service_agreement_lists(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $service = $request->input('service');
        $client_id = $request->input('client_id');
        $search = json_decode($request->input('search'), true);
        $page = $request->input('page');
        $per_page = 20;

        $data = DB::table('service_agreement AS sa')->selectRaw('
            "EDIT" AS type,
            sa.*,
            (' . sqlPDName('pd_cl') . ') AS client_name,
            u_created.name AS created_by,
            u_updated.name AS updated_by
        ')
            ->leftJoin('setting_services AS ss', 'ss.id', '=', 'sa.service_id')
            ->leftJoin('personal_details AS pd_cl', 'pd_cl.id', '=', 'sa.client')
            ->leftJoin('users AS u_created', 'u_created.id', '=', 'sa.created_by')
            ->leftJoin('users AS u_updated', 'u_updated.id', '=', 'sa.updated_by')
            ->groupBy('sa.id')
        ;

        if ($search != null) {
            foreach ($search as $k => $v) {
                if ($v != '') {
                    if ($k == 'assignment_type') {
                        $arr = $this->convert_vue_search($v);
                        if ($arr != []) {
                            $data->whereIn('sa.assignment_type', $arr);
                        }

                    } elseif ($k == 'service') {
                        $arr = $this->convert_vue_search($v);
                        if ($arr != []) {
                            $data->whereIn('sa.service_id', $arr);
                        }

                    } elseif ($k == "date_from") {
                        $data->where("sa.date", '>=', dbDate($v));
                    } elseif ($k == "date_to") {
                        $data->where("sa.date", '<=', dbDate($v));
                    } elseif ($k == "sw") {
                        $data->where(DB::raw(sqlPDName('pd_sw')), 'like', "%$v%");
                    } elseif ($k == "client") {
                        $data->where(DB::raw(sqlPDName('pd_cl')), 'like', "%$v%");
                    } elseif ($k == "vehicle") {
                        $data->where("sv.vehicle_name", 'like', "%$v%");
                    } elseif ($k == 'test') {

                    } else {
                        $data->where("sa.$k", 'like', "%$v%");
                    }
                } //check mepty
            }
        }
        //dd($data->toSQL());

        //CUSTOM DISPLAY
        if ($id != null) {
            $data->where('sa.id', $id);
        }
        if ($type != null) {
            $data->where('sa.assignment_type', $type);
        }
        if ($service != null) {
            $data->where('sa.service_id', $service);
        }
        if ($client_id != null) {
            $data->where('sa.client', $client_id);
        }

        $data->orderBy('sa.id', 'DESC');
        $data = $data->paginate(20);

        return $data;
    }

    public function axios_get_service_agreement(Request $request)
    {
        $id = $request->input('id');

        $data = DB::table('service_agreement AS sa')->selectRaw('
            "EDIT" AS type,
            sa.*,
            (' . sqlPDName('pd_cl') . ') AS client_name,
            u_created.name AS created_by,
            u_updated.name AS updated_by
        ')
            ->leftJoin('setting_services AS ss', 'ss.id', '=', 'sa.service_id')
            ->leftJoin('personal_details AS pd_cl', 'pd_cl.id', '=', 'sa.client')
            ->leftJoin('users AS u_created', 'u_created.id', '=', 'sa.created_by')
            ->leftJoin('users AS u_updated', 'u_updated.id', '=', 'sa.updated_by')
            ->groupBy('sa.id');

        $data->where('sa.id', $id);
        $data = $data->first();

        return (array) $data;
    }

    public function axios_save_service_agreement(Request $request)
    {
        $post = $request->input();
        $d = $post['agreement'];

        $insert_arr = [
            'assignment_type' => $d['assignment_type'] ?? null,
            'service_id' => $d['service_id'] ?? null,
            'client' => $d['client'] ?? null,
            'level' => $d['level'] ?? null,
            'start_date' => dbDate($d['start_date'] ?? null),
            'end_date' => dbDate($d['end_date'] ?? null),
            'review_date' => dbDate($d['review_date'] ?? null),
            'is_active' => $d['is_active'] ?? 1,
            'need_srv_in_holiday' => $d['need_srv_in_holiday'] ?? 0,
            'remark' => $d['remark'] ?? null,
            'case_worker' => $d['case_worker'] ?? null,
        ];

        if ($d['type'] == 'NEW') {
            $agreement = ServiceAgreement::create($insert_arr);
            $agreement_id = $agreement->id;
        }

        if ($d['type'] == 'EDIT') {
            $agreement_id = $d['id'];
            ServiceAgreement::find($agreement_id)->update($insert_arr);
        }

        if ($d['type'] == 'DELETE') {
            ServiceAgreement::find($d['id'])->delete();
        }

        return $agreement_id;
    }

    public function axios_get_service_agreement_data_for_dashboard(Request $request)
    {
        $recent_added_agreeemnt = DB::table('service_agreement')
            ->orderBy('created_at', 'DESC')
            ->limit(20)
            ->get();

        return [
            'recent_added_agreeemnt' => $recent_added_agreeemnt,
        ];
    }

    public function convert_vue_search($arr)
    {
        $filtered = [];
        foreach ($arr as $k => $v) {
            if ($v) {
                $filtered[] = $k;
            }
        }
        return $filtered;
    }

}
