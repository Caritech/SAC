<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPayLevel extends Model
{
    protected $table = "setting_pay_level";

    protected $fillable = [
        'SWPayLevel'
    ];
}
