<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingResidentialStatus extends Model
{
    protected $table = "setting_residential_status";

    protected $fillable = [
        'ResiSts'
    ];
}
