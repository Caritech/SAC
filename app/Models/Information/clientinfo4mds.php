<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class clientinfo4mds extends HistoryModel
{
    protected $primaryKey = 'CustNo';
    public $incrementing = false;
    protected $table = 'clientinfo4mds';
    public $timestamps = false;

    protected $fillable = [
        'CustNo',
        'DOBEst',
        'IndigenSts',
        'MissingSLK',
        'DVACard',
        'ExistOfCarer',
        'CarerDOB',
        'CarerDOBEstFlag',
        'CarerSex',
        'CarerCOB',
        'CarerMainLang',
        'CarerIndiSts',
        'CarerResSts',
        'Carer4MoreThanOne',
        'SrcOfReferral',
        'Housework',
        'Transport',
        'Shopping',
        'Medication',
        'Money',
        'Walking',
        'Bathing',
        'MemProblem',
        'BehProblem',
        'Communication',
        'Dressing',
        'Eating',
        'Toileting',
        'GetOutOfBed',
    ];

    protected $hidden = [
    ];
}
