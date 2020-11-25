<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsCaseRecord extends HistoryModel
{
    protected $table = "personal_details_case_record";

    protected $guarded = ['id'];

    public $timestamps = false;
}
