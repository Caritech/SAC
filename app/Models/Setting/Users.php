<?php

namespace App\Models\Setting;

use  App\Models\BASEMODEL\HistoryModel;

class Users extends HistoryModel
{
    protected $table = "users";

    protected $fillable = [
      'name', 'username','email','password','supervisor'
    ];
    protected $hidden = [
      'password', 'remember_token',
    ];
    protected $casts = [
      'email_verified_at' => 'datetime',
    ];

    //all_user_lists
    function SCOPE_all_user_lists(){
      $q = $this->select(
        'id',
        'name',
        'username',
        'supervisor',
        'email',
        'created_at',
        'updated_at'
      );
      return $q->paginate(10);
    }

    //supervisor_lists
    function SCOPE_supervisor_lists(){
      $q = $this->select('id','name','username')
          ->where('supervisor',1);
      return $q->pluck('name','id');
    }
}
