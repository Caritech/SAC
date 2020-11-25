<?php

namespace Modules\VLife\Entities\Contacts;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "vlife_contacts_company";
    protected $guarded = ['id'];

    public $timestamps = false;
}
