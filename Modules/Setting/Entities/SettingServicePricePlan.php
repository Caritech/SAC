<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingServicePricePlan extends Model
{
    protected $table = "setting_services_price_plan";

    protected $fillable = [
        'service_id', 'title', 'start-date',
        'end_date', 'remark'
    ];

}
