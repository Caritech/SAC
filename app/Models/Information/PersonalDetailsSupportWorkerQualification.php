<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorkerQualification extends HistoryModel
{
    protected $table = "personal_details_support_worker_qualification";
    protected $primaryKey = 'ID'; 
    protected $guarded = ['ID'];
    public $timestamps = false;
}
