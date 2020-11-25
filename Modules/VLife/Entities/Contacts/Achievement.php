<?php

namespace Modules\VLife\Entities\Contacts;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = "vlife_contacts_achievement";
    protected $guarded = ['id'];
    public $timestamps = false;
}
