<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingRelationship extends Model
{
    protected $table = "setting_relationship";

    protected $guarded = ['ID'];
    protected $primaryKey = 'ID';
}
