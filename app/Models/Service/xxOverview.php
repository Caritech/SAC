<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    protected $table = "assignment_overview";

    protected $fillable =[
        'ID','Type','Date','StartTime',
        'EndTime','SWNo','ClientNo','SRNo',
        'VehicleNo'
    ];
    function SCOPE_assignment_overview()
    {
        $q = $this->select('
        Type,
        Date,
        StartTime,
        EndTime,
        SWNo,
        ClientNo,
        SRNo,
        VehicleNo
        ');
        return $q->paginate(10);
    }
    function SCOPE_get_all_type()
    {
        $q = $this->selectRaw('
        Type
        ')->pluck('Type');
        $getAllType=[];
        foreach($q AS $k => $d)
        {
            if(!in_array($d,$getAllType))
            {
                $getAllType[$d] = strtoupper($d);
            }
        }
        return $getAllType;
    }
}
