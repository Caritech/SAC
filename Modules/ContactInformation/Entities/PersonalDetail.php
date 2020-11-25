<?php

namespace Modules\ContactInformation\Entities;


use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    protected $table = "personal_details";
    protected $guarded = ['id'];
    public $timestamps = false;


}
