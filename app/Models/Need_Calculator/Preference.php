<?php

namespace App\Models\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $table = "vlife_nc_preference";
    protected $fillable = [
        'contact_id',
        'nc_medical',
        'nc_medical_follow',
        'nc_critical_illness',
        'nc_critical_illness_follow',
        'nc_death_tpd',
        'nc_death_tpd_follow'
    ];
}
