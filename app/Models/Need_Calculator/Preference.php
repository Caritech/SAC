<?php

namespace App\Models\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $table = "vlife_contacts_nc_preference";
    public $timestamps  = false;
    protected $fillable = [
        'contact_id',
        'nc_medical',
        'medical_follow',
        'nc_critical_illness',
        'nc_critical_illness_follow',
        'nc_death_tpd',
        'death_tpd_follow'
    ];
}
