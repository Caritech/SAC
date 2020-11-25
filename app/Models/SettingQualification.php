<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingQualification extends Model
{
    protected $table = "setting_qualification";

    protected $guarded = ['ID'];
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
