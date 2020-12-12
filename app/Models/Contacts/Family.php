<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $primaryKey = 'contact_id';
    protected $table = "vlife_contacts_family";
    protected $guarded = ['id'];
    public $timestamps = false;
}
