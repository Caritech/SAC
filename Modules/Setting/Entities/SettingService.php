<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingService extends Model
{
    protected $table = "setting_services";

    protected $fillable = [
        'code', 'name', 'parent_id',
        'budget_enabled',
        'customer_invoice_enabled',
        'sw_payment_enabled',
        'dex_enabled',
        'careplan_enabled',
        'css_border_color',
        'css_background_color',
        'css_text_color',
    ];


    public function breakdown()
    {
        return $this->hasMany(
            'App\Models\Setting\SettingServiceBreakdown',
            'service_id',
            'id'
        );
    }

}
