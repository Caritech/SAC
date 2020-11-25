<?php

namespace App\Models\Scheduler;

use Illuminate\Database\Eloquent\Model;

class ServiceAgreement extends Model
{
    protected $table = "service_agreement";

    protected $guarded = ['id'];

    public function service_data($id,$type="ALL"){
      //$type: ALL (DO NOTHING) / ONGOING / ENDED
      $select_agreement_status = '
        IF( (EndDate>=NOW() OR EndDate IS NULL), "ONGOING", "ENDED")
      ';
      $a = $this->from('service_agreement AS sa')
          ->selectRaw('
            sa.*,
            '.$select_agreement_status.' AS AgreementStatus,
            DATEDIFF(NOW(), EndDate ) AS DateDiff,
            NOW() AS DateNow
          ');

      if( in_array($type,['ONGOING','ACTIVE','1','ON']) ){
        $a->whereRaw('('.$select_agreement_status.' = "ONGOING" )');
      }
      if( in_array($type,['ENDED','INACTIVE','0','OFF','END']) ){
        $a->whereRaw('('.$select_agreement_status.' = "ENDED" )');
      }

      return $a;// need to use get to retrieve data
    }
}
