<?php

namespace App\Models\Setting;

use  App\Models\BASEMODEL\HistoryModel;

class UsersSupervisor extends HistoryModel
{
    protected $table = "users_supervisor";

    protected $guarded = ["id"];
}
