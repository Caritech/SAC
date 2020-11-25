<?php

namespace Modules\ContactInformation\Entities;

use Illuminate\Database\Eloquent\Model;

class SupportWorker extends Model
{
    protected $table = "support_worker";
    protected $fillable = [
        'pp_id',
        'sw_no',
        'caseworker_id',
        'supervisor_id',
        'active',
        'is_staff',
        'employ_date',
        'induction_date',
        'resign_date',
    ];

    public function personal_particular()
    {
        return $this->belongsTo('Modules\ContactInformation\Entities\PersonalParticular', 'pp_id');
    }

    public function available_time()
    {
        return $this->hasMany('Modules\ContactInformation\Entities\Sub\SupportWorkerAvailableTime', 'pp_id', 'pp_id');
    }
    public function training()
    {
        return $this->hasMany('Modules\ContactInformation\Entities\Sub\SupportWorkerTraining', 'pp_id', 'pp_id');
    }
    public function qualification()
    {
        return $this->hasMany('Modules\ContactInformation\Entities\Sub\SupportWorkerQualification', 'pp_id', 'pp_id');
    }
    public function pay_point()
    {
        return $this->hasMany('Modules\ContactInformation\Entities\Sub\SupportWorkerPayPoint', 'pp_id', 'pp_id');
    }

}
