<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingReligion extends Model
{
    protected $table = "setting_religion";

    protected $fillable = [
        'ID','Religion'
    ];
}
