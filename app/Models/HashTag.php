<?php

namespace App\Models;

use  App\Models\BASEMODEL\HistoryModel;

class HashTag extends HistoryModel
{
    protected $table = "hashtag";

    protected $fillable = [
        'id', 'hashtag'
    ];
}
