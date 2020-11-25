<?php

namespace App\Models\Information;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use DB;

class tblProviderNumbers extends Model
{
  protected $primarykey = 'ProviderNo';
  protected $table = 'tblprovidernumbers';
  public $timestamps = false;
  public $sortable = ['PreferName'];

  protected $appends = ['StartLeave', 'EndLeave'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'ProviderNo', 'Active', 'Staff', 'PreferName', 'ChinName', 'Qualification', '2ndQuali', 'OtherQuali', 'CulturalBackground', '1stLanguage', '2ndLanguage', 'OtherLanguage', 'FirstAidRequired', 'FirstAidTrainedSince',
      'PoliceCertValidDate', 'DrivingLicRequried', 'DrivingLicExpDate', 'EmployDate', 'InductionDate', 'ResignDate', 'StartLeave', 'EndLeave', 'AvaPubHday'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function tblPersonnelParticulars(){
      return $this->hasOne('App\Models\information\PersonalDetails', 'ProviderNo', 'ProviderNo');
    }

    public function training(){
      return $this->hasMany('App\Models\information\PersonalDetailsSupportWorkerTraining', 'SWNo', 'ProviderNo');
    }

    //with 0000
    public function scopeSWListActive_0000($query){
      $q = DB::table('tblprovidernumbers as tpn')
        ->selectRaw("
                  replace(
                    concat_ws(' ', coalesce(`tpn`.`PreferName`, ''), coalesce(`tpp`.`FirstName`, ''), coalesce(`tpp`.`MiddleName`, ''), coalesce(`tpp`.`Surname`, '')), '  ', ' '
                  ) AS `Name`,
                  if(
                    ( coalesce(`tpn`.`PreferName`, '') <> '' ), trim( concat_ws(' ', `tpn`.`PreferName`, `tpp`.`Surname`)), trim( concat_ws(' ', `tpp`.`FirstName`, `tpp`.`Surname`))
                  ) AS `PName`,
                  `tpn`.`ProviderNo`,
                  `tpp`.`No`,
                  `tpp`.`Street`,
                  `tpp`.`Suburb`,
                  `tpp`.`State`,
                  `tpp`.`PostCode`,
                  `tpp`.`Gender`,
                  `tpp`.`Phone`,
                  `tpp`.`Mobile`,
                  `tpn`.`StartLeave`,
                  `tpn`.`EndLeave`,
                  `tpp`.`Email`,
                  `tpn`.`Staff`,
                  `tpn`.`EmployDate`
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tpn.ProviderNo')
                ->whereRaw('(
                    tpp.LegacyProviderNo >= 8000
                     OR
                    tpp.LegacyProviderNo="0000"
                  )')
                ->whereNotNull('tpp.LegacyProviderNo')
                ->orderBy('tpn.ProviderNo','ASC');
      return DB::table( DB::raw("({$q->toSQL()}) AS t1") )
              ->addBinding($q->getBindings());
    }

    public function scopeAllSupworkerNameLists($query){

      return $query->selectRaw("
                tblprovidernumbers.ProviderNo,
                CONCAT(tblprovidernumbers.ProviderNo, ' | ',
                  TRIM(CONCAT(
                  COALESCE(tblprovidernumbers.PreferName,''),' ',
                  COALESCE(tpp.FirstName,''),' ',
                  COALESCE(tpp.MiddleName,''),' ',
                  COALESCE(tpp.Surname,'')
                  ))) AS SupWorkerName
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tblprovidernumbers.ProviderNo')
                //->where('tblprovidernumbers.Active','=','1')
                ->whereNotNull('tpp.LegacyProviderNo')
                ->orderBy('tblprovidernumbers.ProviderNo','ASC')
                ->pluck('SupWorkerName','ProviderNo');
    }

    public function scopeActiveSupWorkerNameLists($query){

      return $query->selectRaw("
                tblprovidernumbers.ProviderNo,
                CONCAT(tblprovidernumbers.ProviderNo, ' | ',
                  TRIM(CONCAT(
                  COALESCE(tblprovidernumbers.PreferName,''),' ',
                  COALESCE(tpp.FirstName,''),' ',
                  COALESCE(tpp.MiddleName,''),' ',
                  COALESCE(tpp.Surname,'')
                  ))) AS SupWorkerName
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tblprovidernumbers.ProviderNo')
                ->where('tblprovidernumbers.Active','=','1')
                ->whereNotNull('tpp.providerno')
                ->orderBy('tblprovidernumbers.ProviderNo','ASC')
                ->pluck('SupWorkerName','ProviderNo');
    }

    public function scopeSupWorker0000NameLists($query){

      return $query->selectRaw("
                tblprovidernumbers.ProviderNo,
                CONCAT(tblprovidernumbers.ProviderNo, ' | ',
                  TRIM(CONCAT(
                  COALESCE(tblprovidernumbers.PreferName,''),' ',
                  COALESCE(tpp.FirstName,''),' ',
                  COALESCE(tpp.MiddleName,''),' ',
                  COALESCE(tpp.Surname,'')
                  ))) AS SupWorkerName
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tblprovidernumbers.ProviderNo')
                ->whereNotNull('tpp.LegacyProviderNo')
                ->whereRaw('(
                    tpp.LegacyProviderNo >= 8000
                     OR
                    tpp.LegacyProviderNo="0000"
                  )')
                ->orderBy('tblprovidernumbers.ProviderNo','ASC')
                ->pluck('SupWorkerName','ProviderNo');
    }

    public function scopeSupworkerNameLists($query){

      return $query->selectRaw("
                tblprovidernumbers.ProviderNo,
                CONCAT(tblprovidernumbers.ProviderNo, ' | ',
                  TRIM(CONCAT(
                  COALESCE(tblprovidernumbers.PreferName,''),' ',
                  COALESCE(tpp.FirstName,''),' ',
                  COALESCE(tpp.MiddleName,''),' ',
                  COALESCE(tpp.Surname,'')
                  ))) AS SupWorkerName
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tblprovidernumbers.ProviderNo')
                ->where('tblprovidernumbers.Active','=','1')
                ->where('tpp.LegacyProviderNo','>','8000')
                ->orderBy('tblprovidernumbers.ProviderNo','ASC')
                ->pluck('SupWorkerName','ProviderNo');
    }

    public function scopeGetSupWorkerInfo($query,$id){
      return $query->selectRaw("
                Replace(Trim(CONCAT_WS(' ',
                  COALESCE(tblprovidernumbers.PreferName,''),
                  COALESCE(tpp.FirstName,''),
                  COALESCE(tpp.MiddleName,''),
                  COALESCE(tpp.Surname,'')
                  )),'  ',' ') AS SupWorkerName,
                Replace(Trim(CONCAT_WS( ' ',
                  COALESCE(tpp.No,''),
                  COALESCE(tpp.Street,''),
                  ',',
                  COALESCE(tpp.Suburb)
                )),'  ',' ') AS SupWorkerAddr,
                Phone as SupWorkerPhone,
                Mobile as SupWorkerMobile,
                Email as SupWorkerEmail
                ")
                ->Join('personal_details as tpp','tpp.LegacyProviderNo','=','tblprovidernumbers.ProviderNo')
                ->where('tblprovidernumbers.ProviderNo','=',$id)
                ->first();
    }


    public function getStartLeaveAttribute() {
      $nearestonleaverecord = $this->get_nearest_leave_record();
      return $nearestonleaverecord->LeaveStartDate;
    }

    public function getEndLeaveAttribute() {
      $nearestonleaverecord = $this->get_nearest_leave_record();
      return $nearestonleaverecord->LeaveEndDate;
    }


    private function get_nearest_leave_record(){

      $nearestonleaverecord = swonleaverecord::selectRaw("
      DATE_FORMAT(StartDate,'".config('app.mysqlDateFormat')."') AS LeaveStartDate,
      DATE_FORMAT(EndDate,'".config('app.mysqlDateFormat')."') AS LeaveEndDate ")
        ->whereRaw(
          "SWNo = '".$this->ProviderNo."' AND `EndDate` >= NOW()"
        )
        ->orderBy('StartDate','ASC')
        ->first();

        if(!$nearestonleaverecord){
          $nearestonleaverecord = swonleaverecord::selectRaw("
          DATE_FORMAT(StartDate,'".config('app.mysqlDateFormat')."') AS LeaveStartDate,
          DATE_FORMAT(EndDate,'".config('app.mysqlDateFormat')."') AS LeaveEndDate ")
            ->whereRaw(
              "SWNo = '".$this->ProviderNo."' AND `EndDate` <= NOW()"
            )
            ->orderBy('StartDate','DESC')
            ->first();

            if(!$nearestonleaverecord){
              $nearestonleaverecord = new \stdClass();
              $nearestonleaverecord->LeaveStartDate = '-';
              $nearestonleaverecord->LeaveEndDate = '-';
            }
        }

        return $nearestonleaverecord;

    }
}
