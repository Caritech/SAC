<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Fortnight extends Model
{
    //
    protected $table = 'fortnight';

    protected $primaryKey = 'period';
    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'period',
        'year',
        'fortnight',
        'date_from',
        'date_to'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $dates = ['date_from', 'date_to'];

    public function getDateFromAttribute($value){
        return Carbon::parse($value)->format(config('app.dateFormat'));
    }
    public function getDateToAttribute($value){
        return Carbon::parse($value)->format(config('app.dateFormat'));
    }
    public static function getYearFortnight()
    {
        return DB::table('fortnight')
             ->select('*',
                DB::raw('count(*) as totalFortnight'),
                DB::raw('MIN(date_from) as date_from'),
                DB::raw('MAX(date_to) as date_to'))
             ->groupBy('year');
    }

		public static function get_available_years()
    {
        return DB::table('fortnight')
             ->select('year')
             ->groupBy('year');
    }

}
