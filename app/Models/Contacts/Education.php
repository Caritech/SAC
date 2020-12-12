<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $primaryKey = 'contact_id';
    protected $table = "vlife_contacts_education";
    protected $guarded = ['id'];
    public $timestamps = false;
}
