<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailRelationship extends HistoryModel
{
    protected $table = "personal_detail_relationship";

    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
