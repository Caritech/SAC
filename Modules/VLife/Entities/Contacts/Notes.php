<?php

namespace Modules\VLife\Entities\Contacts;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = "vlife_contacts_notes";
    protected $guarded = ['id'];
    public $timestamps = false;
}
