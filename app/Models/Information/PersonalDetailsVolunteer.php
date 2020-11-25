<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsVolunteer extends HistoryModel
{
    protected $table = "personal_details_volunteer";

    //protected $fillable = [
    //    'Active', 'Worker', 'VNo', 'No', 'Street', 'Suburb', 'State', 'PostCode', 'Region', 'Phone', 'Mobile', 'Email', 'DOB', 'Occupation', 'ResidentialSts', 'CountryOfBirth', 'PreferredLang', 'UnderstandEng', 'OtherLang', 'Religion', 'MedicalCond', 'MedicationConcerns', 'DriverLic', 'DrLicExpiry', 'HasVehicle', 'VehInsurance', 'JoinedDate', 'PoliceCertExpiryDate', 'WkChildChkExpiry', 'VolOtherAgcy', 'Availability', 'Freq', 'HoliStart', 'HoliEnd', 'Program', 'Hobbies', 'Skill', 'Note', 'Photo', 'SupportHrs', 'SHrsUpdatedOn', 'Staff', 'IsStaff'
    //];

    protected $primaryKey = 'VNo';
    protected $guarded = ['VID'];


    public $timestamps = false;

}
