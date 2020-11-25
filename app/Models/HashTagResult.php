<?php

namespace App\Models;

use  App\Models\BASEMODEL\HistoryModel;

class HashTagResult extends HistoryModel
{
    protected $table = "hashtag_result";

    protected $guarded = ['id'];

    public $timestamps = false;
}
