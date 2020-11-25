<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCountry extends Model
{
    protected $table = "setting_country";

    protected $fillable = [
        'Code','Country'
    ];
}
