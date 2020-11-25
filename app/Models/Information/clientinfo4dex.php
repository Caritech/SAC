<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class clientinfo4dex extends HistoryModel
{
    protected $primaryKey = 'CustNo';
    public $incrementing = false;
    protected $table = 'clientinfo4dex';
    public $timestamps = false;

    protected $fillable = [
        'CustNo',
        'Consent2ProvideDetails',
        'Consented4FutureContacts',
        'Pseudonym',
        'DOBEst',
        'Country',
        'Language',
        'Indigenous',
        'Disability',
        'Learning',
        'Psychiatric',
        'Sensory',
        'Physical',
        'NotStated',
        'Accommodation',
        'DVACard',
        'HasCarer',
        'IsHomeless',
        'HouseHoldComposition',
        'IncomeSource',
        'IncomeFreq',
        'IncomeAmt',
        '1stArrivalYr',
        '1stArrivalMth',
        'MigrationVisa',
        'Ancestry',
        'EducationLevel',
        'EmploymentStatus',
        'ClientACarer',
        'NDISEligibility',
        'ReferralSource',
        'ReferralSource',
        'Phy',
        'Phy-P',
        'Mental',
        'Mental-P',
        'Personal',
        'Personal-P',
        'Age',
        'Age-P',
        'Community',
        'Community-P',
        'Family',
        'Family-P',
        'Money',
        'Money-P',
        'Edu',
        'Edu-P',
        'Material',
        'Material-P',
        'Housing',
        'Housing-P',
        'ExitReason',
        'RevDate',
        'RevBy',
    ];

    protected $hidden = [
    ];
}
