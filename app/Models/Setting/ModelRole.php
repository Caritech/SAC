<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    protected $table = "model_has_roles";

    protected $fillable = [
      'role_id','model_type','model_id'
    ];

    //role lists
    function SCOPE_model_has_role_lists(){
      $q = $this->select('role_id','model_id')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->selectRaw('
            model_has_roles.model_id,
            roles.name
            ');
      
      return $q->get();
      
    }
}
