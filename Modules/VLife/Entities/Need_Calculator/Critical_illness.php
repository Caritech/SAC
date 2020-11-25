<?php

namespace Modules\VLife\Entities\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class Critical_illness extends Model
{
    protected $table = "vlife_critical_illness";
    protected $guarded = ['id'];
    public $timestamps = false;
}
