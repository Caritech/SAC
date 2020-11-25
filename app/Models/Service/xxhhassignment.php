<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;

class hhassignment extends Model
{
    protected $table='hhassignment';
    protected $fillable = [
		'ID',
		'Service',
		'Fortnight',
		'Holiday',
		'Remark',
		'ProviderNo',
		'HPC',
		'HDA',
		'HRC',
		'HSS',
		'HT',
		'TripDuty',
		'PPC',
		'PMM',
		'PHH',
		'PS',
		'PSA',
		'PPA',
		'PR',
		'Check',
		'HKm',
		'Hexp',
		'PKm',
		'Pexp',
		'CustPay',
		'ProvPay',
		'Vehicle',
		'Edit',
		'AppendDate',
		'Cancel',
		'RevisedDate',
		'RevisedBy',
		'CreatedDate',
		'AgencyNo',
	];

	function SWAssignmentSummary( $arr ){
		$driver = DB::table('driverroster as dr')
				->selectRaw('
				  all.Date AS ServiceDate,
				  all.SWNo AS ProviderNo,
				  Fortnight,
				  Service,
				  sc.CodeName AS ServiceName,
				  all.StartTime AS StartTime,
				  all.EndTime AS EndTime,
				  Truncate(
					( TIME_TO_SEC(EndTime) - TIME_TO_SEC(StartTime) ) / 3600,
				  2) AS Hrs
				')
				->join('assignment_overview as all','all.ID','=','dr.ID')
				->join('setting_service_code as sc','sc.Code','=','dr.Service')
				->whereBetween('all.Date',[ $arr['StartDate'] , $arr['EndDate'] ])
				->where('all.Type','=','dr')
				->where('Service','>','0');

		$duty = DB::table('swdutyroster as sd')
				->selectRaw('
				  all.Date AS ServiceDate,
				  all.SWNo AS ProviderNo,
				  Fortnight,
				  Service,
				  CodeName AS ServiceName,
				  all.StartTime AS StartTime,
				  all.EndTime AS EndTime,
				  Truncate(
					( TIME_TO_SEC(EndTime) - TIME_TO_SEC(StartTime) ) / 3600,
				  2) AS Hrs
				')
				->join('assignment_overview as all','all.ID','=','sd.ID')
				->join('setting_service_code as sc','sc.Code','=','sd.Service')
				->whereBetween('all.Date',[ $arr['StartDate'] , $arr['EndDate'] ])
				->where('all.Type','=','sd')
				->where('Service','>','0');


		/*
		*
		* Check IF condition
		*
		*/



		if(isset($arr['StartTime'])){

		  $STR_whereTimeCondition = '
		  (
			  (
				TIME_TO_SEC("'. $arr['StartTime'] .'")  < TIME_TO_SEC(StartTime)
				AND
				TIME_TO_SEC("'. $arr['EndTime'] .'")  > TIME_TO_SEC(StartTime)
			  )
			  OR
			  (
				TIME_TO_SEC("'. $arr['StartTime'] .'")  < TIME_TO_SEC(EndTime)
				AND
				TIME_TO_SEC("'. $arr['EndTime'] .'")  > TIME_TO_SEC(EndTime)
			  )
			  OR
			  (
				TIME_TO_SEC("'. $arr['StartTime'] .'") BETWEEN TIME_TO_SEC(StartTime) AND TIME_TO_SEC(EndTime)
			  )
			  OR
			  (
				TIME_TO_SEC("'. $arr['EndTime'] .'") BETWEEN TIME_TO_SEC(StartTime) AND TIME_TO_SEC(EndTime)
			  )
			)';
				
		  $driver = $driver->whereRaw($STR_whereTimeCondition);
		  $duty = $duty->whereRaw($STR_whereTimeCondition);
		}


		if(isset($arr['swno'])){
		  $driver = $driver->where('all.SWNo',$arr['swno']);
		  $duty = $duty->where('all.SWNo',$arr['swno']);
		}
		/*
		* END OF
		* Check IF condition
		*
		*/

		$hh = DB::table('hhassignment as hh')
			  ->selectRaw("
			  	all.Date AS ServiceDate,
				ProviderNo,
				Fortnight,
				Service,
	
				IF(
					(
						(  `Service` = 2 OR  `Service` = 4  )
						AND
						( `PPC`  + `PMM`  + `PHH`  + `PS` + `PSA`  + `PPA` + `PR`  = 0 )
					)
					OR (
						`Service` = 1
						AND
						( `HPC`+ `HDA` + `HRC` + `HSS` + `HT`  = 0 )
					),

					CONCAT(
						IF(ts.`ServiceName` = 'HCP' ,
							'P',
							LEFT(ts.`ServiceName`, 1)
						),'NSS'
					),

					IF(ts.`ServiceName` = 'HCP' ,
						'P',
						ts.`ServiceName`
					)
				) AS `ServiceName`,
				all.StartTime AS StartTime,
				all.EndTime AS EndTime,
				Truncate(
				  ( TIME_TO_SEC(EndTime) - TIME_TO_SEC(StartTime) ) / 3600,
				2) AS Hrs
			  ")
			  ->join('setting_service AS ts','ts.ServiceNumber','=','hh.Service')
			  ->join('assignment_overview AS all','all.ID','=','hh.ID')
			  ->union($driver)
			  ->union($duty)
			  ->whereBetween('all.Date',[ $arr['StartDate'] , $arr['EndDate'] ])
			  ->where('all.Type','=','hh')
			  ->where('Service','>','0')
			  ->where('Cancel',0);
		if(isset($arr['swno'])){
		  $hh = $hh->where('ProviderNo',$arr['swno']);
		}
		if(isset($arr['StartTime'])){
		  $hh = $hh->whereRaw($STR_whereTimeCondition);
		}

		/*
		(
		  TIME_TO_SEC("'. $arr['StartTime'] .'")  < TIME_TO_SEC(StartTime)
		  AND
		  TIME_TO_SEC("'. $arr['EndTime'] .'")  < TIME_TO_SEC(StartTime)
		)
		OR
		(
		  TIME_TO_SEC("'. $arr['StartTime'] .'")  > TIME_TO_SEC(EndTime)
		  AND
		  TIME_TO_SEC("'. $arr['EndTime'] .'")  > TIME_TO_SEC(EndTime)
		)


		TIME_TO_SEC("'. $arr['StartTime'] .'") <= TIME_TO_SEC(StartTime)
		AND
		TIME_TO_SEC("'. $arr['StartTime'] .'") >= TIME_TO_SEC(EndTime)
		*/




		return $hh->get();

	  }
	  
}
