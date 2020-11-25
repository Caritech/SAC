<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSalute extends Model
{
    protected $table = "setting_salute";

    protected $fillable = [
        'ID','Salute'
    ];
}
