<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingServiceBreakdown extends Model
{
    protected $table = "setting_services_breakdown";

    protected $fillable = [
        'service_id', 'code', 'name',
        'uom', 'active'
    ];

}
