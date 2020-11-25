<?php

namespace App\Models\BASEMODEL;

use Illuminate\Database\Eloquent\Model;
use App\Models\HistoryLog;

class HistoryModel extends Model
{
    public static function boot(){
      parent::boot();
      self::created(function($model){
        HistoryLog::getDifferent($model,'Insert');
      });//Create Function
      static::deleting(function($model){
        HistoryLog::getDifferent($model,'Delete');
      });
      static::updating(function($model){
        HistoryLog::getDifferent($model,'Update');
      });
    }// END OF Public Boot Function
}
