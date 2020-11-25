<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class transporttime extends Model
{
    //
    protected $table = 'transporttime';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'ID', 'Time'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
