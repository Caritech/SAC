<?php

namespace App\Models\service;

use Illuminate\Database\Eloquent\Model;

class transportassignment extends Model
{
    protected $table='transportassignment';
    protected $primaryKey='TransportID';
    protected $fillable=[
        'TransportID',
        'Field1',
        'Day',
        'Location',
        'Holiday',
        'TransportType',
        'TransportTime',
        'ProviderNo',
        'Sort',
        'VehicleUsed',
        'Remark',
        'Service',
        'PremisesDuty',
        'ProvPayType',
        'Mileage',
        'TimeUsed',
        'Hexp',
        'Dexp',
        'Appended',
        'CreateDate',
        'ChgDate',
        'ChgReason',
        'ChgBy',
        'Charge',
        'DriverRosterID',
        'created_by',
        'updated_by',
        'updated_at',
        'Cancel'
    ];
}
