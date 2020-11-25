<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsAddress extends HistoryModel
{
    protected $table = "personal_details_address";

    protected $guarded = ['id'];
    
    public $timestamps = false;
}
