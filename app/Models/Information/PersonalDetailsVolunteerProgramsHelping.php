<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsVolunteerProgramsHelping extends HistoryModel
{
    protected $table = "personal_details_volunteer_programs_helping";

    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];

    public $timestamps = false;
}
