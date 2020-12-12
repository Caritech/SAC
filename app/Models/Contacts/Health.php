<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $table = "vlife_contacts_health";
    protected $guarded = ['id'];
    public $timestamps = false;
}
