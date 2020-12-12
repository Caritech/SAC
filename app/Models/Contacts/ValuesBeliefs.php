<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

class ValuesBeliefs extends Model
{
    protected $primaryKey = 'contact_id';
    protected $table = "vlife_contacts_values_beliefs";
    protected $guarded = ['id'];
    public $timestamps = false;
}
