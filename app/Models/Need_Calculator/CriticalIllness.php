<?php

namespace App\Models\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class CriticalIllness extends Model
{
    protected $table = "vlife_contacts_nc_critical_illness";
    protected $guarded = ['id'];
    public $timestamps = false;
}
