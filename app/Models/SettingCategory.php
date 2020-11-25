<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model
{
    protected $table = "setting_category";

    protected $fillable = [
        'Category', 'Mail'
    ];
}
