<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class Address extends HistoryModel
{
    protected $table = "address";

    protected $guarded = ['id'];
    
    public $timestamps = false;
}
