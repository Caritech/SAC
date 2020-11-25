<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsVolunteerPrograms extends HistoryModel
{
    protected $table = "personal_details_volunteer_programs";

    protected $fillable = [
        'Program'
    ];
}
