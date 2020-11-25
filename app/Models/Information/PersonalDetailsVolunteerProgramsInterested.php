<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsVolunteerProgramsInterested extends HistoryModel
{
    protected $table = "personal_details_volunteer_programs_interested";

    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];

    public $timestamps = false;
}
