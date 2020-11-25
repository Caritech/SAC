<?php

namespace App\Models\Information;

use App\Models\BASEMODEL\HistoryModel;

class CustomerService extends HistoryModel
{
    protected $table = "customer_service";

    protected $fillable = [
        'CustNo', 'Service', 'SrvLevel', 
        'StartDate', 
        'EndDate', 
        'ReviewDate', 
        'CaseWorkerCode', 
        'Remark', 
        'NeedSrvPubHday', 
        'AgID',
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