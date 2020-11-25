<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsRoles extends HistoryModel
{
    protected $table = "personal_details_roles";

    protected $fillable = [
        'pd_id','role', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
}
