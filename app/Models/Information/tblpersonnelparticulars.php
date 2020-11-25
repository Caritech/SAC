<?php

namespace App\Models\information;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use DB;

class tblpersonnelparticulars extends Model
{
    protected $table = 'tblpersonnelparticulars';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id','MediCareNo', 'ProviderNo', 'CustomerNo', 'PrimaryCarerNo', 'FirstName', 'Middle', 'Surname', 'SRNo', 'Note', 'No', 'Street', 'Suburb', 'State', 'PostCode', 'Region', 'PostatStreetNo', 'PostalStreetName', 'PostalSuburb', 'PostalState', 'PostalPostCode', 'MailingLangCode', 'Phone', 'Mobile', 'DOB', 'Gender', 'MedStatus', 'PayRate', 'Photo', 'eDoc', 'Email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $selectcolumn = [
    ];


    /***************
     * Query SCOPE
     ***************/
    public  function scopeSWAllList()
    {
        $data =DB::table('tblpersonnelparticulars AS tbl')
        ->join('tblprovidernumbers as tbn','tbl.ProviderNo','=','tbn.ProviderNo');
        $data=$data->addSelect(\DB::raw("
        tbl.ProviderNo AS ProviderNo,
        tbl.No AS No,
        tbl.Street AS Street,
        tbl.Suburb AS Suburb,
        tbl.State AS State,
        tbl.PostCode AS PostCode,
        tbl.Gender AS Gender,
        tbl.Phone AS Phone,
        tbl.Mobile AS Mobile,
        tbn.StartLeave AS StartLeave,
        tbn.EndLeave AS EndLeave,
        tbl.Email AS Email
        "))
        ->addSelect(\DB::raw("
        trim(
            replace(
                concat(
                    if(
                        (isnull(tbn.PreferName) or (tbn.PreferName = '')
                    ),'',
                    if(
                        (tbn.PreferName = tbl.FirstName),'',concat(coalesce(tbn.PreferName,''),' ')
                        )
                    ),
                    coalesce(tbl.FirstName,''),' ',
                    if(
                        (isnull(tbl.Middle) or (tbl.Middle = '')
                      ),'',
                      concat(tbl.Middle,' ')
        ),coalesce(tbl.Surname,'')),'  ',' ')) AS name,

        if(
            (isnull(tbn.PreferName) or (tbn.PreferName = '')),
            trim(
                concat(
                    coalesce(tbl.FirstName,''),' ',
                    coalesce(tbl.Middle,'')
                )
            ),
            tbn.PreferName
        ) AS pname 
        "))
        ->where('tbl.ProviderNo','>=','8000')
        ->orWhere('tbl.ProviderNo','=','0000')
        ->orderBy('tbl.ProviderNo','asc');
        return $data;
    }
    public function scopeSWListActive()
    {
        $data = DB::table('tblpersonnelparticulars AS tpp');
        $data = $data->addSelect(\DB::raw("
        replace(
            concat_ws(
                ' ',coalesce(
                    tpn.PreferName,''
                            ),
                    coalesce(
                        tpp.FirstName,''
                            ),
                    coalesce(
                        tpp.Middle,''
                            ),
                    coalesce(
                        tpp.Surname,''
                            )
                    ),'  ',' '
                ) AS Name,
            
            if(
                (coalesce(tpn.PreferName,'') <> ''),
                trim(
                    concat_ws(
                        ' ',tpn.PreferName,tpp.Surname
                            )
                    ),
                trim(
                    concat_ws(
                        ' ',tpp.FirstName,tpp.Surname
                            )
                    )
            ) AS PName,

            tpp.Surname AS LastName,
            tpn.ProviderNo AS ProviderNo,
            tpp.No AS No,
            tpp.Street AS Street,
            tpp.Suburb AS Suburb,
            tpp.State AS State,
            tpp.PostCode AS PostCode,
            tpp.Gender AS Gender,
            tpp.Phone AS Phone,
            tpp.Mobile AS Mobile,
            tpn.StartLeave AS StartLeave,
            tpn.EndLeave AS EndLeave,
            tpp.Email AS Email,
            tpn.Staff AS Staff,
            tpn.EmployDate AS EmployDate 
        "))
        //->addSelect(\DB::raw("'tpp.ProviderNo , CONCAT(tpp.ProviderNo , " | " , tpp.Phone) AS SWName'"))
        ->join('tblprovidernumbers AS tpn','tpn.ProviderNo','=','tpp.ProviderNo')
        ->where('tpp.ProviderNo','>=','8000')
        ->orWhere('tpp.ProviderNo','=','0000')
        ->where('tpn.Active','=',1)
        ->orderBy('tpp.ProviderNo','asc');
        return $data->get();
    }
    public function scopeallColumn($query, $excludecolumn=array()){
        $column = array_diff(\Schema::getColumnListing($this->table), $excludecolumn);
        $collection = collect($column);

        $collection->transform(function ($item, $key) {
            return $this->table.'.'.$item;
        });
   
        $query = $query->select($collection->all());
        return $query;
    }


    /**
     * Support Worker
     */
    public function scopegetSupportWorker($query)
    {
        $query = $query
        ->join('tblprovidernumbers', 'tblpersonnelparticulars.ProviderNo','=','tblprovidernumbers.ProviderNo');
        $query = $this->scopeallColumn($query, array('Photo'))
        ->addSelect('tblprovidernumbers.Active')
        ->addSelect('tblprovidernumbers.Qualification')
        ->addSelect('tblprovidernumbers.2ndQuali as Qualification2')
        ->addSelect('tblprovidernumbers.OtherQuali')
        ->addSelect('tblprovidernumbers.ProviderGrade')
        ->addSelect('tblprovidernumbers.CulturalBackground')
        ->addSelect('tblprovidernumbers.1stLanguage as Language1')
        ->addSelect('tblprovidernumbers.2ndLanguage as Language2')
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                NULLIF(tblprovidernumbers.PreferName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            )) as ProviderName
        '));
        return $query;
    }
    public function scopegetActiveSupportWorker($query)
    {
        $query = $this->scopegetSupportWorker($query);
        $query->where('tblprovidernumbers.Active', 1);
        return $query;
    }
    public function scopegetActiveSupportWorkerAutoComplete($query)
    {
        $query = $this->scopegetSupportWorker($query);
        $query->where('tblprovidernumbers.Active', 1);
        $query = $this->autoCompleteSelect($query,'SW');
        return $query;
    }

    /**
     * Client/Customer/ServiceReceipient
     */
    public function scopegetClient($query)
    {
        $query = $query
        ->join('customerservice', 'tblpersonnelparticulars.CustomerNo','=','customerservice.CustomerNo');

        $query = $this->scopeallColumn($query, array('Photo'))
        ->addSelect('customerservice.ServiceStatusDetail');

        return $query;
    }
    public function scopegetActiveClient($query)
    {
        $query = $this->scopegetClient($query);
        $query->where('customerservice.ServiceStatusDetail', 'A');
        return $query;
    }

    //
    public function scopegetActiveClientAutoComplete($query)
    {
        $query = $this->scopegetClient($query);
        $query->where('customerservice.ServiceStatusDetail', 'A');
        // display as value instead of id cause laravel will convert id to int.
        // ex. customer no 0000 will become 0 which is incorrect
        $query = $this->autoCompleteSelect($query,'Client');
        return $query;
    }


    /*
      For Leave MOdules USe
    */

    public function scopeget_active_cl_ac_tel_number($query)
    {
      $query = $query->join('customerservice','customerservice.CustomerNo','=','tblpersonnelparticulars.CustomerNo');
      $u_query = clone $query;

        $query->select('customerservice.CustomerNo as value')
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                NULLIF(customerservice.PreferedName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            )) as text
        '))
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                REPLACE(tblpersonnelparticulars.Phone," ",""), "|",
                NULLIF(customerservice.PreferedName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            ))  as display
        '))
        ->whereNotNull('tblpersonnelparticulars.Phone');

        $u_query->select('customerservice.CustomerNo as value')
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                NULLIF(customerservice.PreferedName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            )) as text
        '))
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                REPLACE(tblpersonnelparticulars.Mobile," ",""), "|",
                NULLIF(customerservice.PreferedName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            ))  as display
        '))
        ->whereNotNull('tblpersonnelparticulars.Mobile');

        $query->union($u_query);

        return $query;
    }

    public function scopeget_active_sw_ac_tel_number($query)
    {
      //dd($query->get());
      $query = $query->join('tblprovidernumbers', 'tblpersonnelparticulars.ProviderNo','=','tblprovidernumbers.ProviderNo');
      $u_query = clone $query;

        $query->where('tblprovidernumbers.Active', 1);

        $query->select('tblpersonnelparticulars.ProviderNo as value')
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                NULLIF(tblprovidernumbers.PreferName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            )) as text
        '))
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                REPLACE(tblpersonnelparticulars.Phone," ",""), "|",
                NULLIF(tblprovidernumbers.PreferName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            ))  as display
        '))
        ->whereNotNull('tblpersonnelparticulars.Phone');

        $u_query->where('tblprovidernumbers.Active', 1);

        $u_query->select('tblpersonnelparticulars.ProviderNo as value')
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                NULLIF(tblprovidernumbers.PreferName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            )) as text
        '))
        ->addSelect(\DB::raw('
            TRIM(CONCAT_WS(" ",
                REPLACE(tblpersonnelparticulars.Mobile," ",""), "|",
                NULLIF(tblprovidernumbers.PreferName, ""),
                NULLIF(tblpersonnelparticulars.FirstName, ""),
                NULLIF(tblpersonnelparticulars.Middle, ""),
                NULLIF(tblpersonnelparticulars.Surname, "")
            ))  as display
        '))
        ->whereNotNull('tblpersonnelparticulars.Mobile');

        $query->union($u_query);

        return $query;
    }

    public function scopeget_active_client_ac_suburb($query)
    {
      $query = $this->scopegetSupportWorker($query);
      $query->where('tblprovidernumbers.Active', 1);
      $query->select('tblpersonnelparticulars.Suburb as value')
      ->addSelect(\DB::raw('TRIM(tblpersonnelparticulars.Suburb) as text'))
      ->addSelect(\DB::raw('TRIM(tblpersonnelparticulars.Suburb)  as display'))
      ->groupby('tblpersonnelparticulars.Suburb');
      return $query;
    }

    //END OF For Leave Modules use




  	public function scopeGetCustomerLists($query){
  		$query->selectRaw('tblpersonnelparticulars.CustomerNo,
  							CONCAT_WS(" ",COALESCE(FirstName,""),
  										COALESCE(Middle,""),
  										COALESCE(Surname,"")
  									) as SRName,
  							CONCAT_WS(" ",COALESCE(tblpersonnelparticulars.CustomerNo,""),
  										"|",COALESCE(FirstName,""),
  										COALESCE(Middle,""),
  										COALESCE(Surname,"")
  									) as SRNoName
  						')
  				->join('customerservice','customerservice.CustomerNo','=','tblpersonnelparticulars.CustomerNo')
  				->where('tblpersonnelparticulars.CustomerNo','>','3000')
  				->where('customerservice.ServiceStatusDetail','A')
  				->orderBy('tblpersonnelparticulars.CustomerNo');
  		return $query;
  	}

    public function tblProviderNumbers(){
        return $this->belongsTo('App\Models\information\tblProviderNumbers', 'ProviderNo', 'ProviderNo');
    }
    public function clientDOB(){
        if($this->attributes['DOB'] == '0000-00-00 00:00:00'){
            return '';
        }else{
            return date('Y-m-d',strtotime($this->attributes['DOB']));
        }
    }
    public function careplandlrc(){
        return $this->hasMany('App\Models\service\careplandlrc','CustNo','CustomerNo');
    }




    /******************************************

    PRIVATE function

    ******************************************/
    //FOR Concat the name
    private function autoCompleteSelect($query,$type){
      // display as value instead of id cause laravel will convert id to int.
      // ex. ProviderNo no 0000 will become 0 which is incorrect
      if($type == 'SW'){

        $query = $query->select('tblpersonnelparticulars.ProviderNo as value')
                        ->addSelect(\DB::raw('
                            TRIM(CONCAT_WS(" ",
                                tblpersonnelparticulars.ProviderNo, "|",
                                NULLIF(tblprovidernumbers.PreferName, ""),
                                NULLIF(tblpersonnelparticulars.FirstName, ""),
                                NULLIF(tblpersonnelparticulars.Middle, ""),
                                NULLIF(tblpersonnelparticulars.Surname, "")
                            ))  as display
                        '))
                        ->addSelect(\DB::raw('
                            TRIM(CONCAT_WS(" ",
                                NULLIF(tblprovidernumbers.PreferName, ""),
                                NULLIF(tblpersonnelparticulars.FirstName, ""),
                                NULLIF(tblpersonnelparticulars.Middle, ""),
                                NULLIF(tblpersonnelparticulars.Surname, "")
                            )) as text
                        '));;
    
               
      }else{ // if Client

        $query = $query->select('tblpersonnelparticulars.CustomerNo as value')
                        ->addSelect(\DB::raw('
                            TRIM(CONCAT_WS(" ",
                                tblpersonnelparticulars.CustomerNo, "|",
                                NULLIF(tblpersonnelparticulars.FirstName, ""),
                                NULLIF(tblpersonnelparticulars.Middle, ""),
                                NULLIF(tblpersonnelparticulars.Surname, "")
                            ))  as display
                        '))
                        ->addSelect(\DB::raw('
                            TRIM(CONCAT_WS(" ",
                                NULLIF(tblpersonnelparticulars.FirstName, ""),
                                NULLIF(tblpersonnelparticulars.Middle, ""),
                                NULLIF(tblpersonnelparticulars.Surname, "")
                            )) as text
                        '));

      }//END IF

      return $query;
    }
}
