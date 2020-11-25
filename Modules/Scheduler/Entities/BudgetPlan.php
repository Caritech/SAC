<?php

namespace Modules\Scheduler\Entities;

use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    protected $table = "budget_plan";

    protected $fillable = [
        'agreement_id',
        'price_plan_id',
        'client',
        'start_date',
        'end_date',
        'review_date',
        'level',
        'remark',
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
        $updateRules = BudgetPlan::createRules();
        return $updateRules;
    }

}
