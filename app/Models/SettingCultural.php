<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCultural extends Model
{
    protected $table = "setting_cultural";

    protected $fillable = [
        'ID','CultureSpecialty'
    ];
}
