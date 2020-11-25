<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class transporttype extends Model
{
    protected $table = 'transporttype';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'ID', 'Type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
