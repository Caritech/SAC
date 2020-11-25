<?php

namespace Modules\Scheduler\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceAgreement extends Model
{
    protected $table = "service_agreement";

    protected $fillable = [
        'is_active',
        'client',
        'service_id',
        'level',
        'start_date',
        'end_date',
        'review_date',
        'case_worker',
        'remark',
        'need_srv_in_holiday',
        'agency_id',
    ];

    public static function createRules()
    {
        return [
            'is_active' => '',
            'client' => 'required',
            'service_id' => 'required',
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
        $updateRules = ServiceAgreement::createRules();
        return $updateRules;
    }

}
