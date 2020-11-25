<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsCustomerEquipment extends HistoryModel
{
    protected $table = "personal_details_customer_equipment";

    protected $fillable = [
        'Equipment'
    ];
}
