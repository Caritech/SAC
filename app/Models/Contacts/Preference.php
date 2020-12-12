<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $primaryKey = 'contact_id';
    protected $table = "vlife_contacts_preference";
    protected $guarded = ['id'];
    public $timestamps = false;
}
