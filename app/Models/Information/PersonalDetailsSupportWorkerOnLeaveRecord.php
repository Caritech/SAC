<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorkerOnLeaveRecord extends HistoryModel
{
    protected $table = "personal_details_support_worker_leave_record";

    protected $guarded = ['ID'];
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
