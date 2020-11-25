<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Holidays extends Model
{
    //
    protected $table = 'holidays';


    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desc',
        'holiday',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function scopeSearch($query, $search = [])
    {

        foreach((array)$search as $field => $value){
            if($value != ''){
                $query->where($field, 'LIKE', $value);
            }
        }
        return $query;
    }

    public static function getHolidayAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public static function getHolidaysName()
    {
        return DB::table('holidays')
             ->select('*')
             ->groupBy('desc');
    }
}
