<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCustomerLanguage extends Model
{
    protected $table = "setting_customer_languages";

    protected $fillable = [
        'Language'
    ];
}
