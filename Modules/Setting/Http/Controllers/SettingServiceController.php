<?php

namespace Modules\Setting\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\SettingService;
use Modules\Setting\Entities\SettingServiceBreakdown;
use Modules\Setting\Entities\SettingServicePricePlan;
use Modules\Setting\Entities\SettingServicePricePlanBreakdown;
use Modules\Setting\Entities\SettingServicePricePlanGroup;
use Modules\Setting\Entities\SettingServicePricePlanGroupItem;

class SettingServiceController extends Controller
{
    public function get_service_lists(Request $request)
    {

        $post = $request->input();

        $service_lists = DB::table('setting_services');

        if (isset($post['sort'])) {
            $sort = $post['sort'];
            if (strpos($sort, '|') !== false) {
                list($col, $order) = explode('|', $sort);
                $service_lists->orderBy($col, $order);
            }
        }

        if (isset($post['per_page'])) {
            $service_lists = $service_lists->paginate($post['per_page']);
        } else {
            $service_lists = $service_lists->get();
        }

        return $service_lists;
    }

    public function get_service_detail(Request $request)
    {
        $post = $request->input();
        $service_id = $post['service_id'];

        $service = SettingService::findOrFail($service_id);
        $breakdown = SettingServiceBreakdown::where('service_id', $service_id)->get();
        $price_plan = SettingServicePricePlan::where('service_id', $service_id)->get();

        return [
            'service' => $service,
            'breakdown' => $breakdown,
            'price_plan' => $price_plan,
            'lists_uom' => array_to_js_array(config('custom.settings.services_breakdown_uom'))
        ];
    }

    public function get_price_plan_detail(Request $request)
    {
        $post = $request->input();
        $price_plan_id = $post['price_plan_id'];
        $price_plan = SettingServicePricePlan::findOrFail($price_plan_id);

        $service = SettingService::find($price_plan->service_id);
        $price_plan_group = SettingServicePricePlanGroup::where('price_plan_id', $price_plan_id)->get()->toArray();
        $price_plan_group_item = SettingServicePricePlanGroupItem::where('price_plan_id', $price_plan_id)->get()->toArray();
        $price_plan_breakdown = SettingServicePricePlanBreakdown::where('price_plan_id', $price_plan_id)->get()->toArray();
        $lists_price_plan = SettingServicePricePlan::where('id', '!=', $price_plan_id)->get()->toArray();
        $plan_group_items_by_group_id = [];

        foreach ($price_plan_group as $p) {
            $group_id = $p['id'];
            $plan_group_items_by_group_id[$group_id] = (array)$p;
            $plan_group_items_by_group_id[$group_id]['item'] = [];

            foreach ($price_plan_group_item as $pi) {
                if ($pi['group_id'] == $group_id) {
                    $plan_group_items_by_group_id[$group_id]['item'][] = $pi;
                }
            }

        }
        return [
            'service' => $service,
            'price_plan' => $price_plan,
            'price_plan_group' => $price_plan_group,
            'price_plan_group_item' => $price_plan_group_item,
            'price_plan_breakdown' => $price_plan_breakdown,
            'price_plan_group_by_id' => $plan_group_items_by_group_id,
            'lists_price_plan' => $lists_price_plan, //for clone purpose
        ];

    }

    public function add_new_service_price_plan(Request $request)
    {
        $post = $request->input();
        $service_id = $post['service_id'];
        $arr = [
            'service_id' => $service_id,
            'title' => 'NEW Plan As at ' . date('Y-m-d'),
            'start_date' => date('Y-m-d'),
        ];
        $price_plan = SettingServicePricePlan::create($arr);
        $price_plan_id = $price_plan->id;

        $breakdown = SettingServiceBreakdown::where('service_id', $service_id)->get();
        foreach ($breakdown as $s) {
            $breakdown_price = [
                'service_id' => $service_id,
                'price_plan_id' => $price_plan_id,
                'breakdown_id' => $s->id,
                'breakdown_name' => $s->name,
                'breakdown_code' => $s->code,
                'breakdown_uom' => $s->uom,
            ];
            SettingServicePricePlanBreakdown::create($breakdown_price);
        }
        return 'success';
    }

    public function add_new_group_item(Request $request)
    {
        $post = $request->input();
        $item = $post['item'];
        //get group service id and plan id
        $group = SettingServicePricePlanGroup::find($item['group_id']);
        $item['service_id'] = $group->service_id;
        $item['price_plan_id'] = $group->price_plan_id;
        SettingServicePricePlanGroupItem::create($item);
        return 'success';
    }

    public function delete_group_item(Request $request)
    {
        $post = $request->input();
        $group_item_id = $post['group_item_id'];
        SettingServicePricePlanGroupItem::find($group_item_id)->delete();
        return 'success';
    }

    public function update_group(Request $request)
    {
        $post = $request->input();
        $group = $post['group'];
        $group_item = $group['item'];
        unset($group['item']);
        SettingServicePricePlanGroup::find($group['id'])->fill($group)->save();
        foreach ($group_item as $i) {
            SettingServicePricePlanGroupItem::find($i['id'])->fill($i)->save();
        }
        return 'success';
    }

    public function delete_group(Request $request)
    {
        $post = $request->input();
        $group_id = $post['group_id'];
        SettingServicePricePlanGroup::find($group_id)->delete();
        return 'success';
    }

    public function add_new_group(Request $request)
    {
        $post = $request->input();
        $price_plan_id = $post['price_plan_id'];
        $price_plan = SettingServicePricePlan::find($price_plan_id);

        $group = $post['group'];
        $group['price_plan_id'] = $price_plan_id;
        $group['service_id'] = $price_plan->service_id;
        SettingServicePricePlanGroup::create($group);
        return 'success';
    }

    public function update_price_plan(Request $request)
    {
        $post = $request->input();
        $price_plan = $post['price_plan'];
        SettingServicePricePlan::find($price_plan['id'])->fill($price_plan)->save();

        return 'success';
    }

    public function clone_existing(Request $request)
    {
        $post = $request->input();
        $price_plan_id = $post['price_plan_id'];
        $clone_plan_id = $post['clone_plan_id'];

        $chk = DB::Table('setting_services_price_plan')->where('id', $clone_plan_id)->first();
        if ($chk == null) {
            return;
        }

        $service = SettingServicePricePlan::find($price_plan_id);
        $service_id = $service->id;

        //REMOVE current plan group item.
        SettingServicePricePlanGroupItem::where('price_plan_id', $price_plan_id)->delete();
        SettingServicePricePlanGroup::where('price_plan_id', $price_plan_id)->delete();
        SettingServicePricePlanBreakdown::where('price_plan_id', $price_plan_id)->delete();

        //GET data from to be clone
        $group = SettingServicePricePlanGroup::where('price_plan_id', $clone_plan_id)->get()->toArray();
        foreach ($group as $g) {
            $clone_group_id = $g['id'];
            $g['price_plan_id'] = $price_plan_id;
            $g['service_id'] = $service_id;

            $new_group = new SettingServicePricePlanGroup();
            $new_group->fill($g)->save();
            $group_id = $new_group->id;

            $group_item = SettingServicePricePlanGroupItem::where('group_id', $clone_group_id)->get()->toArray();
            foreach ($group_item as $gi) {
                $gi['price_plan_id'] = $price_plan_id;
                $gi['service_id'] = $service_id;
                $gi['group_id'] = $group_id;
                $new_group_item = new SettingServicePricePlanGroupItem();
                $new_group_item->fill($gi)->save();
            }
        } //end of group

        $breakdown = SettingServicePricePlanBreakdown::where('price_plan_id', $clone_plan_id)->get()->toArray();

        foreach ($breakdown as $b) {
            $b['price_plan_id'] = $price_plan_id;
            $b['service_id'] = $service_id;
            $new_breakdown = new SettingServicePricePlanBreakdown();
            $new_breakdown->fill($b)->save();
        }

        return 'success';
    }

    public function save_price_plan_breakdown(Request $request)
    {
        $post = $request->input();
        $price_plan_id = $post['price_plan_id'];
        $price_plan_breakdown = $post['price_plan_breakdown'];
        foreach ($price_plan_breakdown as $b) {
            $id = $b['id'];
            SettingServicePricePlanBreakdown::find($id)->fill($b)->save();
        }
        return 'success';
    }

    public function delete_price_plan(Request $request){
        $post = $request->input();
        $price_plan_id = $post['price_plan_id'];
        SettingServicePricePlan::where('id', $price_plan_id)->delete();
        SettingServicePricePlanGroupItem::where('price_plan_id', $price_plan_id)->delete();
        SettingServicePricePlanGroup::where('price_plan_id', $price_plan_id)->delete();
        SettingServicePricePlanBreakdown::where('price_plan_id', $price_plan_id)->delete();
        return 'success';
    }

    public function add_new_service_breakdown(Request $request){
        $post = $request->input();
        $service_id = $post['service_id'];
        $breakdown = $post['breakdown'];
        $breakdown['service_id'] = $service_id;
        $breakdown['active'] = 1;
        SettingServiceBreakdown::create($breakdown);
        return 'success';
    }

    public function delete_service_breakdown(Request $request){
        $post = $request->input();
        $breakdown_id = $post['breakdown_id'];
        SettingServiceBreakdown::find($breakdown_id)->delete();
        return 'success';
    }
    public function save_service(Request $request){
        $post = $request->input();
        $service = $post['service'];
        SettingService::find($service['id'])->fill($service)->save();
        return 'success';
    }
}
