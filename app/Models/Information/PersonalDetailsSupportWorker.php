<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorker extends HistoryModel
{
    protected $table = "personal_details_support_worker";

    protected $primaryKey = 'pd_id';

    protected $fillable = [
        'pd_id', 'LegacyProviderNo', 'Active', 'supervisor_pd_id', 'Staff', 'PartTime', 'PartTimeHrs', 'PartTimeStart', 'PartTimeEnd', 'SWStudent', 'SWStudentHrs', 'SWStudentStart', 'SWStudentEnd', 'PreferName', 'GetByPost', 'Qualification', '2ndQuali', 'OtherQuali', 'ProviderGrade', 'CulturalBackground', '1stLanguage', '2ndLanguage', 'OtherLang', 'FirstAidRequired', 'FirstAidTrainedSince', 'PoliceCertValidDate', 'PoliceCertAppNo', 'DrivingLicRequired', 'DrivingLicNo', 'DrivingLicExpDate', 'HasVehicle', 'TypeofVehicle', 'VehInsurance', 'InsuranceExpiry', 'MotorLastSrvDate', 'WorkChildChk', 'WorkChildChkExpiry', 'TypeOfService', 'Hobbies', 'EmployDate', 'InductionDate', 'ResignDate', 'StartLeave', 'EndLeave', 'AvaPubHday'
    ];

    public $timestamps = false;

    
}
