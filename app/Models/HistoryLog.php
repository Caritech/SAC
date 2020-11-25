<?php
/*
  (last update 2018 mar 12)
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request,DB, URL;

class HistoryLog extends Model {

  protected $table = 'history_log';
  protected $guarded = ['id'];
  public $timestamps = false;

  /*
    Get changed attribute in text form
  */
  static function getChangeText($model , $task){
    $changes = [];
    $change_txt = '';

    if($task == 'Delete'){
      foreach($model->toArray() as $key => $value){
        $changes[] = "[$key => $value]";
      }
    }else{
      foreach($model->getDirty() as $key => $value){
        $original = $model->getOriginal($key);
        $changes[] = "$key [$original => $value]";
      }
    }

    foreach($changes as $v){
      $change_txt .= $v."\n";
    }

    return $change_txt;
  }

  static function getSummary($model,$task){
    $tbl = $model->getTable(); //table name
		$PK_Name = $model->getKeyName(); // primary key name
		$PK_Value = $model->getKey(); // primary key value

    $summary = "$task $tbl $PK_Name : $PK_Value";
    return $summary;
  }

  static function getApplication($model,$app_name=null){
    $tbl_alias = HistoryLog::tableAlias($model);
    return isset($app_name) ? "$app_name-$tbl_alias" : $tbl_alias;
  }

  public static function getDifferent($model, $task){
    $change_txt = HistoryLog::getChangeText($model,$task); // CHANGE LOG
    $application = HistoryLog::getApplication($model);
    $summary = HistoryLog::getSummary($model,$task);
    $history_arr = [
      'task' => $task,
      'application' => $application,
      'summary' => $summary,
      'change_txt' => $change_txt,
    ];
    HistoryLog::insertHistory($history_arr);
  }
  
  /*
    For insert new history record

    logInterval:
    to determine how long the new log start
    logInterval usiong second to determine ( 1min = 60s ... )
  */
  static function insertHistory($arr, $logInterval=null){
    $history_arr = [
      'User' => \Auth::user()->id,
      'Date' => date('Y-m-d H:i:s'),
      'Action' => $arr['task'],
      'Type' => $arr['application'],
      'Summary' => $arr['summary'],
      'Change' => $arr['summary']."\n".$arr['change_txt'],
      'Location' => "Current: ".Request::url()."\nPrevious: ".URL::previous()
    ];
    $summary = explode('|',$arr['summary']);


    //OLD history based on Summary Text, User ID, and Timestamp
    $old_history = DB::table('history_log')
                  ->where('User',\Auth::user()->id)
                  ->where('Action',$arr['task']);

    if($logInterval == null){ //default
      $old_history->where('Date',date('Y-m-d H:i:s'));
    }else{
      $history_arr['Change'] = $arr['change_txt'];

      $now = date('Y-m-d H:i:s');
      if( is_numeric($logInterval) ){
        $old_history->whereRaw("(
            TIMESTAMPDIFF(SECOND, Date, '".$now."' ) <= $logInterval
        )");
      }else{
        if($logInterval == 'day'){
          $old_history->whereRaw("(
            DATE_FORMAT(Date,'%Y-%m-%d') = DATE_FORMAT('".$now."','%Y-%m-%d')
          )");
        }
      }
    }

    if(isset($summary[1])){
        $old_history->whereRaw('TRIM(SUBSTR(Summary,POSITION("|" IN Summary)+1)) = "'.trim($summary[1]).'"');
    }
    $old_history = $old_history->first();
    if($old_history == null){
      $history = new HistoryLog();
      $history->fill($history_arr);
      $history->save();
    }else{
      $pre_txt = $old_history->Change;
      $history = \DB::table('history_log')
        ->where('ID',$old_history->ID)
        ->update([
          'Change'=> $pre_txt."\n".$history_arr['Change']
        ]);
    }

  }



  /*
  *
  *  TABLE ALIAS
  *  Use for rename existing table to meaningful name
  */
  static function tableAlias($model){
    $table = $model->getTable();

    $alias = [
      //Careplan
      'careplan' => 'CBDC',
      'careplanhh' => 'HACC',
      'careplancacp' => 'HCP',
      'careplanagency' => 'AGENCY',
      'careplandlrc' => 'DLRC',

      //HHAssignment
      'hhassignment' => 'HH',

      //CarePlan
      'careplan' => 'CBDC',
      'careplanhh' => 'HACC',
      'careplancacp' => 'HCP',
      'careplanagency' => 'AGENCY',
      'careplandlrc' => 'DLRC',

      //Leave
      'swonleaverecord' => 'SW',
      'clientonleaverecord' => 'Client',

      //SW Duty Roster
      'swdutyroster' => 'SWDutyRoster',
      'swdutyrostermaster' => 'SWDutyRoster 1st Week',
      'swdutyrostermaster2ndwk' => 'SWDutyRoster 2nd Week',

      //Transport
      'driverroster' => 'DriverRoster',
      'transportassignmentmaster' => 'TransportAssignmentMaster',
      'transportassignment' => 'TransportAssignment',

      //DLRC
      'dlrcsrattendance' => 'DLRC SR Attendance',

      //CBDC
      'cbdcattenddummy' => 'CBDC Attendance Estimation',

      //SETTING
      'reckon_classes' => 'Reckon Classes',
    ];

    return isset($alias[$table]) ? $alias[$table] : $table ;
  }// Table Alias


}
