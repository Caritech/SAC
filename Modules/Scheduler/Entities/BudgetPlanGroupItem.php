<?php

namespace Modules\Scheduler\Entities;

use Illuminate\Database\Eloquent\Model;

class BudgetPlanGroupItem extends Model
{
    protected $table = "budget_plan_group_item";

    protected $fillable = [
        //'budget_plan_id',
        //'group_item_id',
        //'price_plan_id',
        //'group_id',
        //'group_name',
        'title',
        //'type',
        //'input_type',
        'is_checked',
        'value',
        'amount',
        //'reference_group_id',

    ];

    public static function createRules()
    {
        return [];
    }

    public static function updateRules($id = null)
    {
        $updateRules = BudgetPlanBreakdownItem::createRules();
        return $updateRules;
    }

}
