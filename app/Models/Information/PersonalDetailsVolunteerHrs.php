<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsVolunteerHrs extends HistoryModel
{
    protected $table = "personal_details_volunteer_hrs";

    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];

    public $timestamps = false;

}
