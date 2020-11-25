<?php

namespace App\Models\Information;

use  App\Models\BASEMODEL\HistoryModel;

class PersonalDetailsSupportWorkerTraining extends HistoryModel
{
    protected $table = "personal_details_support_worker_training";
    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];
    
    public $timestamps = false;

    public function tblprovidernumbers(){
		return $this->belongsTo('App\Models\information\tblprovidernumbers', 'SWNo', 'ProviderNo');
	}
	public function showFirstAidExpiryDate(){
		$showFirstAidExpiryDate = date('Y-m-d', strtotime('+ '.(365*3).' days',strtotime($this->attributes['TDate'])));
		return $showFirstAidExpiryDate;
	}
	public function showTDate(){
		return date('Y-m-d',strtotime($this->attributes['TDate']));
	}
	public function scopeBasicFistAid($query)
    {
        return $query->where('TName','Basic First Aid');
    }
	public function scopeJoin_tblprovidernumbers($query){
		return $query->leftJoin('tblprovidernumbers', 'tblprovidernumbers.ProviderNo', '=', 'PersonalDetailsSupportWorkerTraining.SWNo');
	}
	public function scopeJoin_tblPersonnelParticulars($query){
		return $query->leftJoin('PersonalDetails', 'PersonalDetails.ProviderNo', '=', 'PersonalDetailsSupportWorkerTraining.SWNo');
	}
	public function scopeTrainingProviderName($query){
		/*
		return $query->addSelect(\DB::raw("
		training.*,
		CONCAT_WS(
			IF(ISNULL(tblprovidernumbers.PreferName),'',tblprovidernumbers.PreferName),' ',
			IF(ISNULL(tblpersonnelparticulars.FirstName),'',tblpersonnelparticulars.FirstName),' ',
			IF(ISNULL(tblpersonnelparticulars.Middle),'',tblpersonnelparticulars.Middle),' ',
			IF(ISNULL(tblpersonnelparticulars.Surname),'',tblpersonnelparticulars.Surname)
		) AS trainingProviderName"
		));

		*/
         return $query->addSelect(\DB::raw("

			DATE_ADD(PersonalDetailsSupportWorkerTraining.TDate , INTERVAL 3 YEAR) as ExpDate,

			training.*,
			TRIM(CONCAT(
				COALESCE(tblprovidernumbers.PreferName,' '),' ',
				COALESCE(personal_details.FirstName,' '),' ',
				COALESCE(personal_details.MiddleName,' '),' ',
				COALESCE(personal_details.Surname,' ')
			)) AS trainingProviderName"
		));

    }
    
}
