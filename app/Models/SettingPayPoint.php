<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPayPoint extends Model
{
    protected $table = "setting_pay_point";

    protected $fillable = [
        'Point','Rate'
    ];
}
