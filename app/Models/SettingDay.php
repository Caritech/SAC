<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingDay extends Model
{
    protected $table = "setting_day";

    protected $fillable = [
        'day'
    ];
}
