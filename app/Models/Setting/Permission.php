<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";

    protected $fillable = [
      'name', 'created_at', 'updated_at','module','permission_name','description'
    ];
}
