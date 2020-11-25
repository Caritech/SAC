<?php

namespace Modules\ContactInformation\Entities\Sub;

use Illuminate\Database\Eloquent\Model;

class SupportWorkerAvailableTime extends Model
{
    protected $table = "support_worker_available_time";
    protected $fillable = [
        'pp_id',
        'sw_no',
        'day',
        'start_time',
        'end_time',
    ];

}
