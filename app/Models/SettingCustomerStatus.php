<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCustomerStatus extends Model
{
    protected $table = "setting_customer_status";

    protected $fillable = [
        'Code','Name'
    ];
}
