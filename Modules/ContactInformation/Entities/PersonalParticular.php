<?php

namespace Modules\ContactInformation\Entities;

use Illuminate\Database\Eloquent\Model;

class PersonalParticular extends Model
{
    protected $table = "personal_particular";
    protected $fillable = [
        'salutation',
        'first_name',
        'middle_name',
        'surname',
        'chinese_name',
        'prefer_name',
        'dob',
        'photo',
        'email',
        'mobile',
        'driving_license',
        'driving_license_no',
        'driving_license_expiring_date',
        'has_vehicle',
        'vehicle_no',
        'vehicle_type',
        'vehicle_insurance_chk',
        'vehicle_insurance_expiring_date',
        'vehicle_last_service_date',
        'police_cert_expiring_date',
        'working_child_check',
        'workign_child_expiring_date',
        'primary_language',
        'seconday_language',
        'other_language',
        'prefer_language',
        'medical_care_no',
        'medical_care_status',
        'slk_no',
        'nationality',
        'understand_english',
        'living_status',
        'housing_type',
        'income_type',
        'religion',
        'occupation',
        'residential_status',
        'note_service_type',
        'note_hobby',
        'note',
        'mailing_langauge_code',
    ];

    public function support_worker()
    {
        return $this->hasOne('SupportWorker');
    }

}
