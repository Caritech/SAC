<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsCustomerMedicalHistory extends HistoryModel
{
    protected $table = "personal_details_customer_medical_history";
    protected $primaryKey = 'ID'; //default take id, it case sensitive
    protected $guarded = ['ID'];

    public $timestamps = false;
}
