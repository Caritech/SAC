<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorkerPayPoint extends HistoryModel
{
    protected $table = "personal_details_support_worker_pay_point";

    protected $primaryKey = 'ID'; 
    protected $guarded = ['ID'];
    public $timestamps = false;
}
