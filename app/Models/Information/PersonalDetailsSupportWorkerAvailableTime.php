<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorkerAvailableTime extends HistoryModel
{
    protected $table = "personal_details_support_worker_available_time";

    protected $guarded = ['ID'];
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
