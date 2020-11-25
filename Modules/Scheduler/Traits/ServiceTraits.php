<?php
namespace App\Traits;

use App\Models\Service\ServicePlan as ServicePlanModel;
use DB;

trait ServiceTraits
{

    /*
    Date must be convert to db date
     */
    function getAssignmentFromPlanByDateRange($from, $to, $client_id = null)
    {
        $date_count = $from;
        $arr = [];
        while ($date_count <= $to) {
            $assignment = $this->getAssignmentFromPlanByDay($date_count, $client_id);
            if ($assignment != []) {
                $arr[$date_count] = $assignment;
            }
            $date_count = date('Y-m-d', strtotime($date_count . ' + 1 day'));
        }
        return $arr;
    }

    /*
    Convert Selected Day's Plan to Assignment
    $SDate => Service Date
    $client_id => use to output single client's assignment (optional)
     */
    function getAssignmentFromPlanByDay($SDate, $client_id = null)
    {
        $FT_Week = getFtWeek($SDate);
        $weekDayNo = DB::table('setting_day')->where('Day', date('D', strtotime($SDate)))->first()->id;

        $assignment = [];

        //Add new home help assignments by copying from the query of HomeHelpCarePlan.
        //For weekly assignment, run the following query.
        $assignment[] = $this->planToAssignment('Weekly_Assignment', $SDate, $client_id, $weekDayNo);

        //For Fortnightly assignment
        if ($FT_Week == 1) {
            //provide service in 1st week
            $assignment[] = $this->planToAssignment('1stWeekService', $SDate, $client_id, $weekDayNo);
        } else {
            //provide service in 2nd week
            $assignment[] = $this->planToAssignment('2ndWeekService', $SDate, $client_id, $weekDayNo);
        } //end if

        // For every 3 weeks assignment, run the following sql.
        $assignment[] = $this->planToAssignment('3WeeksAssignment', $SDate, $client_id, $weekDayNo);

        //For every 4 weeks assignment, run the following sql.
        $assignment[] = $this->planToAssignment('4WeeksAssignment', $SDate, $client_id, $weekDayNo);

        //If the service date is the First Sun-Sat of a month, run the following sql.
        //If SDate < DateSerial(Year(SDate), Month(SDate), 8) Then
        $DateofMonth = new \DateTime($SDate);
        $DateofFirstMonth = $DateofMonth->format('Y-m-07');
        $DateofSecondMonth = $DateofMonth->format('Y-m-14');
        $DateofThirdMonth = $DateofMonth->format('Y-m-21');
        $DateofFourthMonth = $DateofMonth->format('Y-m-28');

        if (strtotime($SDate) - strtotime($DateofFirstMonth) <= 0) {
            $assignment[] = $this->planToAssignment('FirstWeekOfMonth', $SDate, $client_id, $weekDayNo);
        }
        if (strtotime($SDate) - strtotime($DateofFirstMonth) > 0 &&
            strtotime($SDate) - strtotime($DateofSecondMonth) <= 0) {
            $assignment[] = $this->planToAssignment('SecondWeekOfMonth', $SDate, $client_id, $weekDayNo);
        }
        if (strtotime($SDate) - strtotime($DateofSecondMonth) > 0 &&
            strtotime($SDate) - strtotime($DateofThirdMonth) <= 0) {
            $assignment[] = $this->planToAssignment('ThirdWeekOfMonth', $SDate, $client_id, $weekDayNo);
        }
        if (strtotime($SDate) - strtotime($DateofThirdMonth) > 0 &&
            strtotime($SDate) - strtotime($DateofFourthMonth) <= 0) {
            $assignment[] = $this->planToAssignment('FourthWeekOfMonth', $SDate, $client_id, $weekDayNo);
        }

        $assignment = array_filter($assignment, function ($a) {
            return $a != [];
        });

        //FOR EASE IN MODIFICATION
        $merged = [];
        if ($assignment != []) {
            foreach ($assignment as $asgs) {
                foreach ($asgs as $asg) {
                    $merged[] = $asg;
                }
            }
        }
        return $merged;
    } //end of function

    //FUNCTION FOR HH
    function planToAssignment($recurrence_type, $SDate, $client_id, $weekDayNo)
    {
        if ($SDate == null) {
            return [];
        }

        $is_holiday = chkHoliday($SDate);

        $FT_arr = calFT($SDate);
        $FT = $FT_arr['fortnight'];

        $Recurrence = null;
        $Check_Weeks_Sql = null;
        $Order_By_DayGp_CustNo = null;

        if ($recurrence_type == 'Weekly_Assignment') {
            $Recurrence = 1;
        } elseif ($recurrence_type == '1stWeekService') {
            $Recurrence = 2;
        } elseif ($recurrence_type == '2ndWeekService') {
            $Recurrence = 3;
        } elseif ($recurrence_type == '3WeeksAssignment') {
            $Recurrence = 4;
            $Check_Weeks_Sql = "(DATEDIFF( '$SDate' , c.start_date ) MOD 21 = 0)";
        } elseif ($recurrence_type == '4WeeksAssignment') {
            $Recurrence = 5;
            $Check_Weeks_Sql = "(DATEDIFF( '$SDate' , c.start_date ) MOD 28 = 0)";
        } elseif ($recurrence_type == 'FirstWeekOfMonth') {
            $Recurrence = 10;
        } elseif ($recurrence_type == 'SecondWeekOfMonth') {
            $Recurrence = 20;
        } elseif ($recurrence_type == 'ThirdWeekOfMonth') {
            $Recurrence = 30;
        } elseif ($recurrence_type == 'FourthWeekOfMonth') {
            $Recurrence = 40;
        }

        $query = DB::table('service_plan AS c')
            ->selectRaw('
			    c.id AS plan_id,
                assignment_type,
                client,
                service_id,
                "' . $SDate . '" AS service_date,
                location_id,
                vehicle_id,
                start_time,
                end_time,
                sw,
                remark,
                "' . $is_holiday . '" AS is_holiday
            ');

        /*
        use to check client is on leave or not
        if return null mean client is no leave data, which means is no on leave
         */
        /*
        $query->leftJoin('clientonleaverecord as l', function($query) use($SDate){
        $query->on('c.CustNo', '=', 'l.ClientId');
        $query->on('l.StartDate', '<=', DB::raw('"'.$SDate.'"'));
        $query->on('l.EndDate', '>=', DB::raw('"'.$SDate.'"'));
        });
         */

        /*
        For specific client only
        used in " service/homehelp/client_service_list " page
         */
        if ($client_id != null) {
            $query = $query->where('c.client', $client_id);
        }

        if ($Check_Weeks_Sql != null) {
            $query = $query->whereRaw($Check_Weeks_Sql);
        }

        $query = $query->where('c.recurrence_id', $Recurrence);

        //For every week no need Baed on day gp
        if ($Recurrence != 3 && $Recurrence != 4) {
            $query = $query->where('day_id', $weekDayNo);
        }

        $query = $query->where(function ($q) use ($SDate) {
            $q->where(function ($q1) use ($SDate) {
                $q1->where('c.start_date', '<=', $SDate)
                    ->where(function ($q2) use ($SDate) {
                        $q2->where('c.end_date', '>=', $SDate) //not expire yet
                            ->orWhereNull('c.end_date'); // no expire date
                    }); //end q2...........
            }) //end q1...........
            ;
            //end q3...........
        }) //end q............
        //  ->whereNull('l.ClientId')// checking leave based the available of leave data
            ->orderBy('c.day_id')
            ->orderBy('c.client');
        return $query->get()->toArray();
    }

    /*
    Use to get proposed Assignment
     */
    function getProposedAssignment(ServicePlanModel $plan)
    {
        $StartDate = $plan->start_date;
        $EndDate = $plan->end_date;
        $Recurrence = $plan->recurrence_id;
        $RecurrenceStart = $StartDate;
        $Day = $plan->day_id;

        $allowed_recurrence = [1, 2, 3, 4, 5, 10, 20, 30, 40, 50];

        if (!in_array($Recurrence, $allowed_recurrence)) {
            return [];
        }

        if ($EndDate == '') {
            $EndDate = SaveDateToDB(date('Y-m-d', strtotime(' + 365 day')));
        }

        $firstAsgDate = null;
        $temp_date = $StartDate;
        // WEEKLY Assignment
        if ($Recurrence == 1) {
            while ($firstAsgDate == null && strtotime($temp_date) <= strtotime($EndDate)) {
                if ($Day == ConvertToDayGp($temp_date)) {
                    $firstAsgDate = $temp_date;
                }
                $temp_date = date('Y-m-d', strtotime($temp_date . ' + 1 day'));
            }
            $day_increment = 7;
        }

        //FORTNIGHLY
        if ($Recurrence == 2 || $Recurrence == 3) {
            $firstWeek = $Recurrence == 2 ? 1 : 0;

            while ($firstAsgDate == null && strtotime($temp_date) <= strtotime($EndDate)) {
                $fortnight = calFT($temp_date);

                $day_diff = (strtotime($temp_date) - strtotime($fortnight['date_from'])) / 3600 / 24 + 1;
                $weekCount = ($day_diff <= 7) ? 1 : 0;

                if ($Day == ConvertToDayGp($temp_date) && $firstWeek == $weekCount) {
                    $firstAsgDate = $temp_date;
                }
                $temp_date = date('Y-m-d', strtotime($temp_date . ' + 1 day'));
            }
            $day_increment = 14;
        }

        //Every 3 week
        if ($Recurrence == 4) {
            $day_increment = 21;
            $firstAsgDate = $this->getEveryWeekFirstAsgDate($RecurrenceStart, $StartDate, $day_increment);

        }

        //Every 4 week
        if ($Recurrence == 5) {
            $day_increment = 28;
            $firstAsgDate = $this->getEveryWeekFirstAsgDate($RecurrenceStart, $StartDate, $day_increment);

        }

        //Init Assignment Variable
        $Assignment = [];

        if ($Recurrence >= 10) {
            while (strtotime($temp_date) <= strtotime($EndDate)) {
                $numOfWeek = sectionOfMonth($temp_date) . '0';
                if ($Day == ConvertToDayGp($temp_date) && $Recurrence == $numOfWeek) {
                    $Assignment[] = $temp_date;
                }
                $temp_date = date('Y-m-d', strtotime($temp_date . ' + 1 day'));
            }

        }

        if ($Recurrence < 10 && $firstAsgDate != null) {
            while (strtotime($firstAsgDate) <= strtotime($EndDate)) {
                $Assignment[] = $firstAsgDate;
                $firstAsgDate = date('Y-m-d', strtotime($firstAsgDate . ' + ' . $day_increment . ' day'));
            }
        }

        return $Assignment;
    }

    /* Calculate fisrt assignment date */
    function getEveryWeekFirstAsgDate($reccurence_start, $start_date, $increment)
    {
        $r_start = SaveDateTODB($reccurence_start);
        if ($start_date == null) {return $r_start;}

        // repeat until a date is greate than start date
        while ($r_start <= $start_date) {
            $carbon_r_start = Carbon::parse($r_start);
            $carbon_start_date = Carbon::parse($start_date);

            $diff = $carbon_r_start->diffInDays($carbon_start_date);

            $r_start = $carbon_r_start->addDay($increment);
            $r_start = $r_start->format('Y-m-d H:i:s');
        }
        return $r_start;
    }

}
