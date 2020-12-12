<?php

namespace App\Models\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $table = "vlife_medical";
    protected $guarded = ['id'];
    public $timestamps = false;
}
