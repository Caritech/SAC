<?php

namespace App\Models\Information;

use App\Models\BASEMODEL\HistoryModel;

class PersonalDetails extends HistoryModel
{
    protected $table = "personal_details";
    protected $guarded = ['id'];
    public $timestamps = false;


    public function personal_detail_customer()
    {
        return $this->hasOne('App\Models\Information\PersonalDetailsCustomer','pd_id','id');
    }

}
