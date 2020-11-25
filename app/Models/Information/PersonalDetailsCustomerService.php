<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsCustomerService extends HistoryModel
{
    protected $table = "personal_details_customer_service";

    protected $fillable = [
        'LegacyCustomerNo','EngName', 'PreferedName', 'ServiceStatus', 'ServiceStatusDetail', 'RAS', 'CACP', 'HACC', 'CBDC', 'DLRC', 'FRAIL', 'CANT', 'MAND', 'CAMB', 'VIET', 'MADD', 'SPECNEED', 'DLRCPC', 'HACCSSG', 'AGENCY', 'Discount', 'Tue', 'Wed', 'Thu', 'Fri', 'Bill', 'OnHoliday', 'CustSts', 'StartSts', 'EndSts', 'StartHoliday', 'EndHoliday'
    ];
}
