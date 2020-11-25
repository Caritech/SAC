<?php

namespace Modules\VLife\Entities\Contacts;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "vlife_contacts_address";
    protected $guarded = ['id'];
    public $timestamps = false;
}
