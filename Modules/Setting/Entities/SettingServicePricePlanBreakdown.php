<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingServicePricePlanBreakdown extends Model
{
    protected $table = "setting_services_price_plan_breakdown_items";

    protected $fillable = [
        'service_id', 'price_plan_id', 'breakdown_id',
        'breakdown_name', 'breakdown_code','breakdown_uom',
        'wk','wk_half','wk_ot','wk_ot_half',
        'sat','sat_half','sat_ot','sat_ot_half',
        'sun','sun_half','sun_ot','sun_ot_half',
        'pb','pb_half','pb_ot','pb_ot_half',
    ];

}
