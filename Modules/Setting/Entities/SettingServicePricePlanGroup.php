<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingServicePricePlanGroup extends Model
{
    protected $table = "setting_services_price_plan_group";

    protected $fillable = [
        'service_id', 'price_plan_id', 'group_name',
        'created_at', 'created_by','updated_at','updated_by'
    ];

}
