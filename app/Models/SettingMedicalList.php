<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingMedicalList extends Model
{
    protected $table = "setting_medical_list";

    protected $fillable = [
        'ID','MedicalName','ColorCode'
    ];
}
