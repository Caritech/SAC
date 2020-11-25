<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingServicePricePlanGroupItem extends Model
{
    protected $table = "setting_services_price_plan_group_item";

    protected $fillable = [
        'service_id', 'price_plan_id', 'group_id',
        'title', 'type','input_type','default_value',
        'created_at', 'created_by','updated_by','updated_at',
        'reference_group', 'level1','level2','level3',
        'level4', 'refer_group_id'

    ];

}
