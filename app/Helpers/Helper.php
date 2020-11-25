<?php
function db_json_encode($data)
{
    foreach ($data as $k => $v) {
        $data[$k] = json_encode($v);
    }
    return $data;
}
function db_json_decode($data)
{
    foreach ((array)$data as $k => $v) {
        $data[$k] = json_decode($v, true);
    }
    return $data;
}

function get_client_info($request, $client_id = null)
{
    if ($client_id == null) {
        $client_id = $request->input('client_id');
    }

    $data = \DB::table('personal_details AS pd')
        ->selectRaw('
              ' . sqlPDName('pd') . ' AS name,
              pd.Gender AS gender,
              pd.DOB AS dob,
              pdc.LegacyCustomerNo AS client_no,
              pd.id
            ')
        ->where('pd.id', $client_id)
        ->leftJoin('personal_details_customer AS pdc', 'pdc.pd_id', '=', 'pd.id')
        ->first();
    return (array) $data;
}



//return rest api error
function restError($arr)
{
    header('HTTP/1.1 500 Internal Server Action Reject');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode($arr));
}

function getFtWeek($date)
{
    return App\Http\Controllers\Setting\FortnightController::fortnightWeek($date);
}
function chkHoliday()
{
    return false;
}
function curFT()
{
    return App\Http\Controllers\Setting\FortnightController::calFortnight(date('Y-m-d'));
}
function calFT($date)
{
    return App\Http\Controllers\Setting\FortnightController::calFortnight($date);
}
//Use to determine section of month
function sectionOfMonth($date)
{
    $day = date('d', strtotime($date));
    $section = $day / 7;

    //If got decimal point
    if (is_float($section)) {
        $section = (int) $section + 1;
    }
    return $section;
}

function setIfValueEmpty($val)
{
    $val = trim($val);
    if ($val == "") {
        $val = 'n/a';
    }
    return $val;
}

function generateSqlStr($sql, $binding = null)
{
    if (is_object($sql)) {
        $sql_str = $sql->toSql();
        $binding = $sql->getBindings();
    } else {
        $sql_str = $sql;
    }
    foreach ($binding as $bind) {
        $letter_pos = strpos($sql_str, '?');
        $sql_str = substr_replace($sql_str, '"' . $bind . '"', $letter_pos, 1);
    }
    return $sql_str;
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//the slk generation sql code
function sql_slk($alias = '')
{
    $alias = $alias == '' ? '' : $alias . '.';

    //covert name
    $first = $alias . 'FirstName';
    $middle = $alias . 'MiddleName';
    $last = $alias . 'Surname';
    $dob = $alias . 'DOB';
    $gender = $alias . 'Gender';

    return "
      UPPER(
          CONCAT(
            IF(SUBSTRING(
              REGEXP_REPLACE($last, '[^a-z]', ''),2,1)='', 2,
                SUBSTRING(
                  REGEXP_REPLACE($last, '[^a-z]', ''),2,1)
              ),
            IF(SUBSTRING(
              REGEXP_REPLACE($last, '[^a-z]', ''),3,1)='',2,
                SUBSTRING(
                  REGEXP_REPLACE($last, '[^a-z]', ''),3,1)
              ),
            IF(SUBSTRING(
              REGEXP_REPLACE($last, '[^a-z]', ''),5,1)='',2,
                SUBSTRING(
                  REGEXP_REPLACE($last, '[^a-z]', ''),5,1)
              ),
            IF(SUBSTRING(
              REGEXP_REPLACE(
                CONCAT(
                  COALESCE(TRIM($first),''),
                  COALESCE(TRIM($middle),'')
                ), '[^a-z]', ''
              ),2,1)='',
              2,
              SUBSTRING(
                  REGEXP_REPLACE(
                    CONCAT(
                      COALESCE(TRIM($first),''),
                      COALESCE(TRIM($middle),'')
                    ), '[^a-z]', ''
                  ),2,1)
            ),
            IF(SUBSTRING(
              REGEXP_REPLACE(
                CONCAT(
                  COALESCE(TRIM($first),''),
                  COALESCE(TRIM($middle),'')
                ), '[^a-z]', ''
              ),3,1)='',
              2,
              SUBSTRING(
                  REGEXP_REPLACE(
                    CONCAT(
                      COALESCE(TRIM($first),''),
                      COALESCE(TRIM($middle),'')
                    ), '[^a-z]', ''
                  ),3,1)
            ),
            IF(SUBSTRING($dob,9,2)='00','',SUBSTRING($dob,9,2)),
            IF(SUBSTRING($dob,6,2)='00','',SUBSTRING($dob,6,2)),
            IF(SUBSTRING($dob,1,4)='0000','',SUBSTRING($dob,1,4)),
            IF($gender='M',1,2)
          )
        )
    ";
}

function showAssignmentCodeLabel($assignment_id, $service_id)
{
    $d = DB::table('setting_services')->where('id', $service_id)->first();
    $html = "
    <span class='assignment-code' style='
        border-color:#{$d->css_border_color};
        background:#{$d->css_background_color};
        color:#{$d->css_text_color};
      '>"
        . $d->code . "-" . str_pad($assignment_id, 6, 0, STR_PAD_LEFT) . "
    </span>
   ";
    return $html;
}

function htmlServiceCodeExplain()
{
    $data = DB::table('setting_services')->get();
    $html = '';
    foreach ($data as $d) {
        $html .= "
      <div class='col-md-4'>
        <span class='assignment-code' style='
          border-color:#{$d->css_border_color};
          background:#{$d->css_background_color};
          color:#{$d->css_text_color};
        '>"
            . $d->code . "-000001
        </span>
      </div>
    ";
    }
    return $html;
}

function tooltipInfo($info)
{
    return '
     <span style="color:#1e88e5" title="' . $info . '">
        <i class="fa fa-info-circle"></i>
    </span>
  ';
}

/*
BY
 */
function ServiceName($id)
{
    $d = \DB::table('setting_services')->where('id', $id)->first();
    return $d->name ?? 'N/A';
}
function displayDate($date)
{
    if (is_null($date) || $date == '0000-00-00 00:00:00' || $date == '') {
        return null;
    } else {

        return date(config('app.dateFormat'), strtotime($date));
    }
}
function displayTime($time)
{
    if (is_null($time) || $time == '0000-00-00 00:00:00' || $time == '') {
        return null;
    } else {
        return date(config('app.timeFormat'), strtotime($time));
    }
}
function dbDate($date, $date_only = true)
{
    return saveDateToDb($date, $date_only);
}
function saveDateToDb($date, $date_only = false)
{
    if (is_null($date) || $date == '0000-00-00 00:00:00' || $date == '') {
        return null;
    } else {
        if ($date_only == true) {
            return date('Y-m-d', strtotime($date));
        } else {
            return date('Y-m-d 00:00:00', strtotime($date));
        }
    }
}
function saveTimeToDb($time, $time_only = false)
{
    if ($time == '' or $time == null) {
        return null;
    } else {
        if ($time_only == true) {
            return date('H:i:s', strtotime($time));
        } else {
            return date('Y-m-d H:i:s', strtotime($time));
        }
    }
}

function TrueFalseIcon($v)
{
    if ($v == 1) {
        return '<i class="fa fa-check green" aria-hidden="true" ></i>';
    } else {
        return '<i class="fa fa-times red" aria-hidden="true"></i>';
    }
}

function YesOrNoOption()
{
    return ['' => 'All', '1' => 'Yes', '0' => 'No'];
}

function UserName($id)
{
    $u = DB::table('users')->where('id', $id)->first();
    return $u != null ? $u->name : 'N/A';
}

/* Personal Contact Name */
function PDName($pd_id)
{
    $pd = DB::Table('personal_details')
        ->where('id', $pd_id)
        ->selectRaw('
    TRIM(REPLACE( CONCAT_WS(" ",
      COALESCE(PreferName, ""),
      COALESCE(FirstName, ""),
      COALESCE(MiddleName, ""),
      COALESCE(Surname, "")
    ), "  ", " ")) AS Name
  ')
        ->first();
    return $pd ? $pd->Name : 'N/A';
}

function sqlPDName($alias)
{
    return 'TRIM(REPLACE( CONCAT_WS(" ",
      COALESCE(' . $alias . '.PreferName, ""),
      COALESCE(' . $alias . '.FirstName, ""),
      COALESCE(' . $alias . '.MiddleName, ""),
      COALESCE(' . $alias . '.Surname, "")
    ), "  ", " "))';
}

function sw_name_lists()
{
    return App\Models\Information\tblprovidernumbers::SupWorkerNameLists();
}

function RecurrenceName($id)
{
    $r = DB::table('setting_recurrence')
        ->where('id', $id)
        ->first();
    return $r != null ? $r->recurrence : 'N/A';
}

function DayName($id)
{
    $d = DB::table('setting_day')
        ->where('id', $id)
        ->first();
    return $d != null ? $d->day : 'N/A';
}

function LegacyCustomerNo($pd_id)
{
    $pd = DB::Table('personal_details')
        ->select('LegacyCustomerNo')
        ->where('id', $pd_id)
        ->first();
    return $pd ? $pd->LegacyCustomerNo : 'N/A';
}

function ConvertToDayGp($date)
{
    $dayName = date('D', strtotime($date));
    $dayid = DB::table('setting_day')->where('day', $dayName)->first()->id;
    return $dayid;
}

function all_client_lists()
{
    $client_lists = DB::table('personal_details_customer AS pd_c')
        ->leftJoin('personal_details AS pd', 'pd.id', '=', 'pd_c.pd_id')
        ->selectRaw('
                      pd_id,
                      TRIM(
                        REPLACE(
                          CONCAT_WS(" ",
                            COALESCE(pd.PreferName, ""),
                            COALESCE(pd.FirstName, ""),
                            COALESCE(pd.MiddleName, ""),
                            COALESCE(pd.Surname, ""),
                            COALESCE(pd.LegacyCustomerNo, "")
                          ), "  ", " ")
                      ) AS name
                    ')
        ->pluck('name', 'pd_id');
    return $client_lists;
}

function all_service_lists()
{
    $srv_lists = DB::Table('setting_services')->orderBy('ServiceNumber', 'ASC')->pluck('ServiceName', 'ServiceNumber');
    return $srv_lists;
}

function day_lists()
{
    $day_lists = DB::table('setting_day')->pluck('day', 'id');
    return $day_lists;
}

function recurrence_lists()
{
    $rec_lists = DB::table('setting_recurrence')->pluck('recurrence', 'id');
    return $rec_lists;
}

function active_inactive_option()
{
    return ['' => 'All', '1' => 'Active', '0' => 'InActive'];
}

function gender_option()
{
    return ['' => 'All', 'F' => 'Female', 'M' => 'Male'];
}

function leave_status_option()
{
    return ['' => 'All', '1' => 'Available', '2' => 'On Leave'];
}

function expiry_lists()
{
    return ['' => 'ALL', 'expired3mth' => 'Expired in 3 Months', 'expired' => 'Expired', 'nexpired' => 'Non-Expired'];
}

function parttime_lists()
{
    return ['' => 'ALL', '1' => 'Part Time Only', '0' => 'Non-PartTime Only'];
}

function is_staff_lists()
{
    return ['' => 'ALL', '0' => 'Non Staff', '1' => 'Staff Only'];
}

function pd_role($id)
{
    $personal_details_roles = \DB::table('personal_details_roles')->selectRaw('role')->where('pd_id', $id)->get();
    $pd_roles = [];
    foreach ($personal_details_roles as $roles) {
        $pd_roles[] = $roles->role;
    }
    return $pd_roles;
}

function medicare_status_lists($id = null)
{
    $data = ['0' => 'No MediCare No.', '1' => 'Collected', '2' => 'No Consent or Not Available'];
    if ($id) {
        return $data[$id];
    }
    return $data;
}

function address_type_lists()
{
    return ['billing' => 'billing', 'service' => 'service', 'pick up' => 'pick up', 'return' => 'return', 'mailing' => 'mailing', 'residential' => 'residential'];
}

function case_worker_lists()
{
    $data =
        \DB::table('personal_details_staff')
        ->leftJoin('personal_details', 'personal_details_staff.pd_id', 'personal_details.id')
        ->selectRaw('personal_details.id,TRIM(REPLACE(CONCAT(personal_details.FirstName," ",personal_details.MiddleName," ",personal_details.Surname),"  "," ")) as name')
        ->where('case_worker', 1)
        ->pluck('name', 'id')
        ->prepend('-', '');

    return $data;
}
function convertObjToArray($obj)
{
    $array = [];
    foreach ($obj as $k => $v) {
        foreach ($v as $key => $value) {
            $array[$k] = $value;
        }
    }
    return $array;
}
function all_assingment_overview()
{
    $data =
        \DB::table('assignment_overview')->select('*')->get();
    return $data;
}
function html_checkbox($name, $display_name, $default_value = 'checked', $class = '', $readonly = false)
{
    $untouchable = $readonly ? 'untouchable' : '';
    $checked = ($default_value == 'checked') ? 'checked' : '';
    return '
		<div class="[ form-group ' . $class . ']" style="margin-bottom:5px;">
				<input type="checkbox" name="' . $name . '" id="' . $name . '" autocomplete="off" ' . $checked . ' />
				<div class="[ btn-group ]">
						<label for="' . $name . '" class=" btn btn-default ' . $untouchable . ' ">
								<span class="[ fa fa-check ]"></span>
								<span></span>
						</label>
						<label for="' . $name . '" class="btn btn-default active ' . $untouchable . '">
								' . $display_name . '
						</label>
				</div>
		</div>';
}
function SWName($id, $type = "full")
{

    $sw = \DB::table('tblprovidernumbers as tpn')
        ->selectRaw('
					TRIM(REPLACE(
						 CONCAT_WS(" ",COALESCE(tpn.PreferName, ""), COALESCE(tpp.FirstName, ""),
											COALESCE(tpp.Middle, ""), COALESCE(tpp.Surname, "") ), "  ", " "
					)) AS Full,
					TRIM(REPLACE(
						 CONCAT_WS(" ",COALESCE(tpp.FirstName, ""),
											COALESCE(tpp.Middle, ""),
											COALESCE(tpp.Surname, "") ), "  ", " "
					)) AS Name,
					tpn.PreferName AS Prefer,
          tpp.FirstName,
          tpp.Middle,
          tpp.Surname,
          tpn.ProviderNo
				')
        ->leftJoin('tblpersonnelparticulars as tpp', 'tpp.ProviderNo', '=', 'tpn.ProviderNo')
        ->where('tpn.ProviderNo', $id)
        ->first();
    if ($sw == null) {
        return "N/A";
    } else {
        switch ($type) {
            case "full":
                $name = $sw->Full;
                break;
            case "prefer":
                if ($sw->Prefer != '' || $sw->Prefer != null) {
                    $name = $sw->Prefer;
                } else {
                    $name = $sw->FirstName;
                }
                break;
            case 'short':
                if ($sw->Prefer != '' || $sw->Prefer != null) {
                    $name = "{$sw->ProviderNo} {$sw->Prefer} {$sw->Surname} ";
                } else {
                    $name = "{$sw->ProviderNo} {$sw->FirstName} {$sw->Surname} ";
                }
                break;
            case "mail":
                if ($sw->Prefer != '' || $sw->Prefer != null) {
                    $name = "{$sw->Prefer} {$sw->Surname} ";
                } else {
                    $name = "{$sw->FirstName} {$sw->Surname} ";
                }
                break;
            default:
                $name = $sw->Name;
        } //End switch
        return $name;
    }
}
function DayGpToDay($dayGp)
{
    $day = DB::table('day')->where('ID', $dayGp)->first()->Day;
    return $day;
}

/*
________________________________________________________________________________________
For HTML blade input
-easyInput($displayName, $name, $value, $class='')
-easySelect($displayName, $name,$lists, $value, $class='')
-easyTextarea($displayName, $name, $value, $class='')
-easyCheckbox($displayName, $name, $value, $class='')
-----------------------------
 */
function easyLabel($name, $value, $class = '')
{
    if (strpos($class, 'datepicker') !== false) {
        $value = displayDate($value);
    }
    if (strpos($class, 'timepicker') !== false) {
        $value = displayTime($value);
    }
    $html = '
			<div class="col-md-12 input-line">
				' . \Form::label('', $name, ['class' => 'label-control col-md-6']) . '
				' . \Form::label($name, $value, ['class' => 'label-control col-md-6 ' . $class]) . '
			</div>
			';
    return $html;
}

function easyInput($displayName, $name, $value, $class = '')
{
    if (strpos($class, 'datepicker') !== false) {
        $value = displayDate($value);
    }
    if (strpos($class, 'timepicker') !== false) {
        $value = displayTime($value);
    }
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::text($name, $value, ['class' => 'form-control ' . $class]) . '
				</div>
			</div>';
    return $html;
}

function easySelect($displayName, $name, $lists, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::select($name, $lists, $value, ['placeholder' => '-', 'class' => 'form-control ' . $class]) . '
				</div>
			</div>';
    return $html;
}
function easyMultiSelect($displayName, $name, $lists, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-12']) . '
				<div class="col-md-12">
				' . \Form::select($name, $lists, $value, ['multiple' => 'true', 'class' => 'form-control ' . $class]) . '
				</div>
			</div>';
    return $html;
}

function easyTextarea($displayName, $name, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::textarea($name, $value, ['rows' => '4', 'class' => 'form-control vertical-textarea ' . $class]) . '
				</div>
			</div>';
    return $html;
}

function easyCheckbox($displayName, $name, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::checkboxhidden($name, 1, $value, ['style' => 'width:20px;height:20px', 'class' => ' ' . $class]) . '
				</div>
			</div>';
    return $html;
}

//Custom Use
function easyCustomCheckbox($displayName, $name, $preValue = 1, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::checkboxhidden($name, $preValue, $value, ['style' => 'width:20px;height:20px', 'class' => ' ' . $class]) . '
				</div>
			</div>';
    return $html;
}

function easyEmailInput($displayName, $name, $value, $class = '')
{
    $html = '<div class="col-md-12 input-line customInputStyle">
				' . \Form::label($name, $displayName, ['class' => 'label-control col-md-6']) . '
				<div class="col-md-6">
				' . \Form::text($name, $value, ['class' => 'form-control default-email-field ' . $class, 'data-role' => "tagsinput", 'placeholder' => $displayName]) . '
				</div>
			</div>';
    return $html;
}
function tam_driver_roster_lists($location, $ServiceDate)
{
    $ServiceDate = SaveDateToDB($ServiceDate);
    $transport_type = ['1' => '1', '2' => '2'];

    foreach ($transport_type as $k => $v) {
        $driver_roster[$k] = DB::table('driverroster as dr')
            ->SelectRaw('
                  dr.ID,
                  all.SWNo,
                  REPLACE( CONCAT_WS(" ",COALESCE(tpp.Firstname, ""), COALESCE(tpp.Middle, ""), COALESCE(tpp.Surname, "") ), "  ", " ") as SWName,
                  all.StartTime,
                  all.EndTime,
                  ServiceName,
                  ampm.Period
                ')
            ->leftJoin('assignment_overview as all', 'all.ID', '=', 'dr.ID')
            ->leftJoin('tblservices as ts', 'ts.ServiceNumber', '=', 'dr.Service')
            ->leftJoin('tblpersonnelparticulars as tpp', 'tpp.ProviderNo', '=', 'dr.SWNo')
            ->leftJoin('ampm', 'ampm.ID', '=', 'dr.AMPM')
            ->where('AMPM', $v) //Get Separate driver
            ->where('all.Date', $ServiceDate)
            ->where('Location', $location)
            ->where('Cancel', '0')
            ->orderBy('all.SWNo', 'ASC')
            ->orderBy('Service', 'ASC')
            ->orderBy('all.StartTime', 'ASC')
            ->orderBy('all.EndTime', 'ASC')
            ->get();
    }
    $driver_roster_lists = [];
    $array_select_lists = [];

    foreach ($transport_type as $k => $v) {

        foreach ($driver_roster[$k] as $d) {
            $STime = DisplayTime($d->StartTime);
            $ETime = DisplayTime($d->EndTime);

            $driver_roster_lists[$k][$d->SWNo][$d->ID] = '[' . $d->Period . '](' . $d->ServiceName . ')' . $d->SWNo . ' ' . $d->SWName . ' [ ' . $STime . '-' . $ETime . ' ] ';
        }
        $driver_roster_lists[$k] = isset($driver_roster_lists[$k]) ? $driver_roster_lists[$k] : [];
        $array_select_lists[$k] = $driver_roster_lists[$k];
    }

    $select[1] = $array_select_lists[1];
    $select[2] = $array_select_lists[2];

    return $select;
}
function checkStaff($swno)
{
    $chk = DB::table('tblprovidernumbers')
        ->where('ProviderNo', $swno)
        ->first();
    if ($chk != null && $chk->Staff == 1) {
        return true;
    } else {
        return false;
    }
}

function showDashIfEmpty($val)
{
    $val = trim($val);
    if ($val !== null && $val != "") {
        return $val;
    }
    return '-';
}
