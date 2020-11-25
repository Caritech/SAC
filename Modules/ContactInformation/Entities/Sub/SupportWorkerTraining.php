<?php

namespace Modules\ContactInformation\Entities\Sub;

use Illuminate\Database\Eloquent\Model;

class SupportWorkerTraining extends Model
{
    protected $table = "support_worker_training";
    protected $fillable = [
        'pp_id',
        'sw_no',
        'day',
        'start_time',
        'end_time',
    ];

}
