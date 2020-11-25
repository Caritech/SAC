<?php

namespace App\Models\service;

use Illuminate\Database\Eloquent\Model;

class tblvehicle extends Model
{
    //
    protected $table = 'tblvehicle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'ID', 'VehicleNo', 'VehicleName', 'StartDate', 'EndDate', 'Capacity', 'Remark'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
    
}
