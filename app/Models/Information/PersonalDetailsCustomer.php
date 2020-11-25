<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsCustomer extends HistoryModel
{
    protected $table = "personal_details_customer";

    protected $guarded = ['id'];
    protected $primaryKey = 'pd_id';
    public $timestamps = false;
}
