<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class SettingRole extends Model
{
  /*
    protected $table = "setting_role";

    protected $fillable = [
      'role_name', 'role_description','role_code'
    ];

    //role lists
    function SCOPE_role_lists(){
      $q = $this->select('id','role_name')
          ->selectRaw('
            CONCAT("(",role_code,") ", role_name) AS name
          ')
          ->orderBy('Level','DESC')
          ->where('status',1);
      return $q->pluck('name','id');
    }
    */
    protected $table = "roles";

    protected $fillable = [
      'name', 'created_at', 'updated_at'
    ];

    //role lists
    function SCOPE_role_lists(){
      $q = $this->select('id','name')->orderBy('id','ASC');
      
      return $q->pluck('name','id');
      
    }
}
