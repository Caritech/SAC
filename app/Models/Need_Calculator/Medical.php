<?php

namespace App\Models\Need_Calculator;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $table = "vlife_medical";
    protected $fillable = [
        'contact_id',
        'description',
        'total_amount',
        'type',
        'created_by',
        'updated_by'
    ];
}
