<?php

namespace Modules\Scheduler\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Scheduler\Entities\BudgetPlan;
use Modules\Scheduler\Entities\BudgetPlanBreakdownItem;
use Modules\Scheduler\Entities\BudgetPlanEvergreen;
use Modules\Scheduler\Entities\BudgetPlanGroupItem;
use Validator;

//use Modules\Scheduler\Traits\ServiceTraits;

class BudgetPlanController extends Controller
{
    //use ServiceTraits;
    public function __construct()
    {$this->middleware('auth');}

    public function get_client_budget_plan(Request $request)
    {
        $client_id = $request->client_id;
        $client = get_client_info($request);
        $lists_agreement = DB::table('service_agreement AS sa');
        $lists_agreement->selectRaw('
            sa.*,
            CONCAT(
                IFNULL(ss.code,"N/A"),
                " [Level:", IFNULL(sa.level,"N/A"), " ] ",
                " [",IFNULL(sa.start_date,"N/A"), " - ",
                IFNULL(sa.end_date,"N/A"),
                " ]"

            ) AS text
        ');
        $lists_agreement = $lists_agreement->leftJoin('setting_services AS ss', 'sa.service_id', '=', 'ss.id')
            ->where('client', $client_id)
            ->orderBy('sa.start_date', 'DESC')
            ->get();
        return [
            'client' => $client,
            'lists_agreement' => $lists_agreement,
        ];
    }

    public function get_client_budget_plan_lists(Request $request)
    {
        $post = $request->input();
        $client_id = $request->input('client_id');
        $lists = BudgetPlan::where('client', $client_id);
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

    public function get_budget_plan_detail(Request $request)
    {
        $post = $request->input();
        $budget_plan_id = $request->input('budget_plan_id');
        $budget_plan = BudgetPlan::find($budget_plan_id);
        $client_id = $budget_plan->client;
        $client = get_client_info(null, $client_id);

        $agreement_id = $budget_plan->agreement_id;
        $agreement = DB::table('service_agreement AS sa');
        $agreement->SelectRaw('
            sa.*,
            TRIM(REPLACE(
                CONCAT_WS(" ",COALESCE(pd.LegacyProviderNo, ""),COALESCE(pd.PreferName, ""), COALESCE(pd.FirstName, ""),
                                COALESCE(pd.MiddleName, ""), COALESCE(pd.Surname, "") ), "  ", " "
            )) AS client_name,
            ss.code AS service_code
        ');
        $agreement->leftJoin('setting_services AS ss', 'ss.id', 'sa.service_id');
        $agreement->leftJoin('personal_details AS pd', 'pd.id', 'sa.client');
        $agreement->where('sa.id', $agreement_id);
        $agreement = $agreement->first();

        $budget_plan_breakdown = DB::table('budget_plan_breakdown_item')->where('budget_plan_id', $budget_plan_id)->get();

        $lists_price_plan = DB::table('setting_services_price_plan AS pp');
        $lists_price_plan->selectRaw('
            pp.*,
            CONCAT(title," [Effective Start:",start_date,"]") AS text
        ');
        if ($agreement != null) {
            $lists_price_plan->where('service_id', $agreement->service_id);
        }
        $lists_price_plan = $lists_price_plan->orderBy('start_date', 'DESC')->get();

        $lists_price_plan_breakdown = DB::table('setting_services_price_plan_breakdown_items AS bi')
            ->selectRaw('
                bi.*,
                CONCAT("[", breakdown_code,"] ",breakdown_name," [", breakdown_uom,"]") AS text
            ')
            ->where('price_plan_id', $budget_plan->price_plan_id)
            ->get();

        $evergreen_price = DB::table('setting_servic_price_plan_cdc_evergreen_price')->where('price_plan_id', $budget_plan->price_plan_id)->first();
        $evergreen = [
            'budget_plan_id' => $budget_plan_id,
            'price_plan_id' => $budget_plan->price_plan_id,
            'AMFee' => $evergreen_price->AMFee ?? 0,
            'PMFee' => $evergreen_price->PMFee ?? 0,
            'CombinedFee' => $evergreen_price->CombinedFee ?? 0,
        ];
        $this->create_budget_plan_evergreen_blueprint($budget_plan);
        $budget_plan_evergreen = BudgetPlanEvergreen::find($budget_plan_id);

        //Get Grouped Item
        $budget_plan_group_item = DB::Table('budget_plan_group_item')->where('budget_plan_id', $budget_plan_id)->get();

        return [
            //View onlt data
            'client' => $client,
            'agreement' => $agreement,

            //main form data
            'budget_plan' => $budget_plan,
            'budget_plan_breakdown' => $budget_plan_breakdown,
            'budget_plan_evergreen' => $budget_plan_evergreen,
            'budget_plan_group_item' => $budget_plan_group_item,

            //for dropdown option
            'lists_level' => range(0, 4),
            'lists_price_plan' => $lists_price_plan,
            'lists_price_plan_breakdown' => $lists_price_plan_breakdown,
        ];
    }

    //FOR INITiliase use
    public function create_budget_plan_evergreen_blueprint($budget_plan)
    {
        $budget_plan_id = $budget_plan->id;
        $price_plan_id = $budget_plan->price_plan_id;
        $chk = BudgetPlanEvergreen::find($budget_plan_id);
        if ($chk == null) {
            $evergreen_price = DB::table('setting_servic_price_plan_cdc_evergreen_price')->where('price_plan_id', $budget_plan->price_plan_id)->first();
            $evergreen = [
                'budget_plan_id' => $budget_plan_id,
                'price_plan_id' => $price_plan_id,
                'AMFee' => $evergreen_price->AMFee ?? 0,
                'PMFee' => $evergreen_price->PMFee ?? 0,
                'CombinedFee' => $evergreen_price->CombinedFee ?? 0,
            ];
            $budget_plan_evergreen = BudgetPlanEvergreen::create($evergreen);
        }
        return $budget_plan_evergreen ?? null;

    }

    public function create_budgte_plan(Request $request)
    {
        $post = $request->input();
        $client_id = $post['client_id'];
        $budget_plan = $post['budget_plan'];
        $budget_plan['client'] = $client_id;

        $validator = Validator::make($budget_plan, BudgetPlan::createRules());
        if ($validator->fails()) {
            $error_msg = covert_validation_errror_to_html($validator);
            return ['errors' => $validator->errors(), 'error_message' => $error_msg];
        }
        $budgetPlan = new BudgetPlan();
        $budgetPlan->fill($budget_plan)->save();

        return 'success';
    }

    public function save_budget_plan(Request $request)
    {
        $budget_plan_id = $request->input('budget_plan_id');
        $budget_plan = $request->input('budget_plan');
        $budget_plan_breakdown = $request->input('budget_plan_breakdown');
        $budget_plan_evergreen = $request->input('budget_plan_evergreen');
        $budget_plan_group_item = $request->input('budget_plan_group_item');

        BudgetPlan::find($budget_plan_id)->fill($budget_plan)->save();
        BudgetPlanEvergreen::find($budget_plan_id)->fill($budget_plan_evergreen)->save();
        foreach ($budget_plan_breakdown as $b) {
            BudgetPlanBreakdownItem::find($b['id'])->fill($b)->save();
        }
        foreach ($budget_plan_group_item as $g) {
            BudgetPlanGroupItem::find($g['id'])->fill($g)->save();
        }
        return 'success';
    }

    public function update_budget_plan_pricing(Request $request)
    {
        $budget_plan_id = $request->budget_plan_id;
        $price_plan_id = $request->price_plan_id;

        BudgetPlan::find($budget_plan_id)->fill(['price_plan_id' => $price_plan_id])->save();

        //GET NEW PRICING
        $breakdown_price = DB::Table('setting_services_price_plan_breakdown_items')
            ->where('price_plan_id', $price_plan_id)
            ->get();

        //GET OLD DATA
        $bp_breakdown = DB::table('budget_plan_breakdown_item')->where('budget_plan_id', $budget_plan_id)->get();

        foreach ($bp_breakdown as $bb) {

            foreach ($breakdown_price as $price) {

                if ($bb->breakdown_id == $price->breakdown_id) {
                    $pricing = $this->generate_breakdown_price_for_budget_plan($price);
                    BudgetPlanBreakdownItem::find($bb->id)->fill($pricing)->save();
                    break;
                }
            }
        }
        return 'success';
    }

    public function generate_breakdown_price_for_budget_plan($setting_breakdown_price)
    {
        $day = ['wk', 'sat', 'sun', 'pb'];
        $breakdown_pricing = (array) $setting_breakdown_price;
        $pricing = [];
        foreach ($breakdown_pricing as $col => $price) {
            foreach ($day as $d) {
                if (strpos($col, $d) !== false) {
                    $pricing[$col . '_price'] = $price;
                }
            }
        }
        return $pricing;
    }

    public function add_new_service_item(Request $request)
    {
        $budget_plan_id = $request->budget_plan_id;
        $budget_plan = BudgetPlan::find($budget_plan_id);
        $price_plan_id = $budget_plan->price_plan_id;
        $breakdown_id = $request->breakdown_id;

        $breakdown_pricing = DB::table('setting_services_price_plan_breakdown_items')
            ->where('id', $breakdown_id)
            ->first();
        $breakdown_pricing = (array) $breakdown_pricing;

        $new_breakdown = [
            'budget_plan_id' => $budget_plan_id,
            //FOR REFERENCE PRUPOSe
            'breakdown_id' => $breakdown_pricing['breakdown_id'],
            'breakdown_name' => $breakdown_pricing['breakdown_name'],
            'breakdown_code' => $breakdown_pricing['breakdown_code'],
            'breakdown_uom' => $breakdown_pricing['breakdown_uom'],

        ];

        $day = ['wk', 'sat', 'sun', 'pb'];
        foreach ($breakdown_pricing as $col => $price) {
            foreach ($day as $d) {
                if (strpos($col, $d) !== false) {
                    $new_breakdown[$col . '_price'] = $price;
                }
            }
        }

        $condition = [
            'budget_plan_id' => $budget_plan_id,
            'breakdown_id' => $breakdown_id,
        ];
        DB::table('budget_plan_breakdown_item')->updateOrInsert($condition, $new_breakdown);
        return 'success';
    }

    public function delete_service_breakdown_item(Request $request)
    {
        $budget_plan_id = $request->budget_plan_id;
        $breakdown_id = $request->breakdown_id;
        BudgetPlanBreakdownItem::find($breakdown_id)->delete();
        return 'success';
    }

}
