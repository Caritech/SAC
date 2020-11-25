<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;

class day extends Model
{
    protected $table = 'setting_day';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id', 'day'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	function scopeDayLists($query , $type=""){ 
		$query=$query->select('day','id');
		switch($type){
			case 'WeekDay':
				$query=$query->whereBetween('id',array('2','6'));
			break;
		}
		$query=$query->lists('day','id');
		return $query;
	}
}
