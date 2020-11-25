<?php

namespace Modules\ContactInformation\Entities\Sub;

use Illuminate\Database\Eloquent\Model;

class SupportWorkerPayPoint extends Model
{
    protected $table = "support_worker_point_pay";
    protected $fillable = [
        'pp_id',
        'sw_no',
        'day',
        'start_time',
        'end_time',
    ];

}
