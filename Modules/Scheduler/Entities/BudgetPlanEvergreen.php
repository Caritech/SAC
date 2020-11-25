<?php

namespace Modules\Scheduler\Entities;

use Illuminate\Database\Eloquent\Model;

class BudgetPlanEvergreen extends Model
{
    protected $table = "budget_plan_cdc_evergreen_price";
    protected $primaryKey = "budget_plan_id";
    protected $fillable = [
        'budget_plan_id',
        'price_plan_id',
        'AMFee',
        'PMFee',
        'CombinedFee',
        'ChkMonAM',
        'ChkMonPM',
        'ChkTueAM',
        'ChkTuePM',
        'ChkWedAM',
        'ChkWedPM',
        'ChkThuAM',
        'ChkThuPM',
        'ChkFriAM',
        'ChkFriPM',
        'ChkSatAM',
        'ChkSatPM',
        'ChkSunAM',
        'ChkSunPM',
    ];

    public static function createRules()
    {
        return [

        ];
    }

    public static function updateRules($id = null)
    {
        $updateRules = BudgetPlan::createRules();
        return $updateRules;
    }

}
