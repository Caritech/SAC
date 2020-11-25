<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    protected $table = 'location';
    public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'ID', 'Active', 'Active', 'Location', 'Description', 'Centre'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [
  ];

  protected $guarded = [
  ];

  public function scopeActive($query){
      $query->where('Active','1')->where('Centre','1');
      return $query;
  }
  
  public function scopeLocationLists($query){
      return $query->selectRaw(" ID , CONCAT(Location , ' | ' , Description) as location ")
                  ->orderBy('ID','ASC')
                  ->lists('location','ID');
  }
}
