<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTraining extends Model
{
    protected $table = "setting_training";

    protected $fillable = [
        'TCode','TName'
    ];
}
