<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLanguage extends Model
{
    protected $table = "setting_language";

    protected $fillable = [
        'LCode','Language'
    ];
}
