<?php

namespace Modules\Scheduler\Entities;

use Illuminate\Database\Eloquent\Model;

class BudgetPlanBreakdownItem extends Model
{
    protected $table = "budget_plan_breakdown_item";

    protected $fillable = [
        'budget_plan_id',
        'breakdown_id',
        'breakdown_name',
        'breakdown_code',
        'breakdown_uom',
        'wk_price',
        'wk_half_price',
        'wk_ot_price',
        'wk_ot_half_price',
        'wk_unit',
        'wk_ot_unit',
        'wk_cost',
        'wk_ot_cost',
        'sat_price',
        'sat_half_price',
        'sat_ot_price',
        'sat_ot_half_price',
        'sat_unit',
        'sat_ot_unit',
        'sat_cost',
        'sat_ot_cost',

        'sun_price',
        'sun_half_price',
        'sun_ot_price',
        'sun_ot_half_price',
        'sun_unit',
        'sun_ot_unit',
        'sun_cost',
        'sun_ot_cost',

        'pb_price',
        'pb_half_price',
        'pb_ot_price',
        'pb_ot_half_price',
        'pb_unit',
        'pb_ot_unit',
        'pb_cost',
        'pb_ot_cost',
    ];

    public static function createRules()
    {
        return [
            'is_active' => '',
            'client' => 'required',
            'service_id' => '',
            'level' => '',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'case_worker' => '',
            'remark' => '',
            'need_srv_in_holiday' => '',
            'agency_id' => '',
        ];
    }

    public static function updateRules($id = null)
    {
        $updateRules = BudgetPlanBreakdownItem::createRules();
        return $updateRules;
    }

}
