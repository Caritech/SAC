<?php

namespace Modules\DataAdapter\Http\Controllers;

use DB;
use Illuminate\Routing\Controller;

class DataAdapterController extends Controller
{
    public function sync_information()
    {
        ContactGenerator::generate_contact_table();
        //return;
        //start sync v1 tblpersonal particular
        //sw
        DB::table('personal_particular')->truncate();
        DB::table('personal_particular_address')->truncate();
        DB::table('personal_particular_contact')->truncate();
        DB::table('personal_particular_medical_history')->truncate();
        DB::table('personal_particular_relationship')->truncate();
        DB::table('personal_particular_leave')->truncate();
        DB::table('personal_particular_journey')->truncate();

        DB::table('support_worker')->truncate();
        DB::table('support_worker_available_time')->truncate();
        DB::table('support_worker_pay_point')->truncate();
        DB::table('support_worker_qualification')->truncate();
        DB::table('support_worker_training')->truncate();
        //customer
        DB::table('customer')->truncate();
        DB::table('customer_dex')->truncate();
        DB::table('customer_mds')->truncate();

        DB::table('agency')->truncate();

        $this->sync_information_support_worker();
        $this->sync_information_customer();
        $this->sync_information_volunteer();
        dd('Success sync SW, Custoemr, Volunteer');
    }

    public function sync_information_support_worker()
    {
        $sw = DB::connection('v1')->table('tblprovidernumbers')->get();
        foreach ($sw as $s) {

            $pp = DB::connection('v1')->table('tblpersonnelparticulars')->where('ProviderNo', $s->ProviderNo)->first();
            $swno = $s->ProviderNo;
            //insert pp
            $insert_pp = [
                'salutation' => null,
                'first_name' => $pp->FirstName,
                'middle_name' => $pp->Middle,
                'surname' => $pp->Surname,
                'chinese_name' => $s->ChinName,
                'prefer_name' => $s->PreferName,
                'dob' => $pp->DOB,
                'gender' => $pp->Gender,
                'photo' => $pp->Photo,
                'phone' => $pp->Phone,
                'email' => $pp->Email,
                'mobile' => $pp->Mobile,
                'driving_license' => $s->DrivingLicRequired,
                'driving_license_no' => $s->DrivingLicNo,
                'driving_license_expiring_date' => $s->DrivingLicExpDate,
                'has_vehicle' => $s->HasVehicle,
                'vehicle_no' => null,
                'vehicle_type' => $s->TypeofVehicle,
                'vehicle_insurance_chk' => $s->VehInsurance,
                'vehicle_insurance_expiring_date' => $s->InsuranceExpiry,
                'vehicle_last_service_date' => $s->MotorLastSrvDate,
                'primary_language' => $s->{'1stLanguage'},
                'seconday_language' => $s->{'2ndLanguage'},
                'other_language' => $s->OtherLang,
                'prefer_language' => null,

                'medical_care_no' => $pp->MediCareNo,
                'medical_care_status' => $pp->MedStatus,
                'slk_no' => $pp->slk,
                'nationality' => $s->CulturalBackground,
                'understand_english' => null,
                'living_status' => null,
                'housing_type' => null,
                'income_type' => null,
                'religion' => null,
                'note_service_type' => $s->TypeOfService,
                'note_hobby' => $s->Hobbies,
                'note' => $pp->Note,
                'mailing_langauge_code' => $pp->MailingLangCode,
            ];

            $pp_id = DB::Table('personal_particular')->insertGetId($insert_pp);

            $insert_sw = [
                'pp_id' => $pp_id,
                'sw_no' => $s->ProviderNo,
                'caseworker_id' => $s->CaseWorkerID,
                'supervisor_id' => $s->SWSupervisorID,
                'active' => $s->Active,
                'is_staff' => $s->Staff,
                'employ_date' => $s->EmployDate,
                'induction_date' => $s->InductionDate,
                'resign_date' => $s->ResignDate,
                'part_time' => $s->PartTime,
                'part_time_hrs' => $s->PartTimeHrs,
                'part_time_start' => $s->PartTimeStart,
                'part_time_end' => $s->PartTimeEnd,
                'sw_student' => $s->SWStudent,
                'sw_student_hrs' => $s->SWStudentHrs,
                'sw_student_start' => $s->SWStudentStart,
                'sw_student_end' => $s->SWStudentEnd,
            ];
            $sw_id = DB::table('support_worker')->insertGetId($insert_sw);

            //insert support_worker_available_time
            $available_time = DB::connection('v1')->table('sptwkravailtime')->where('ProvNo', $s->ProviderNo)->get();
            foreach ($available_time as $a) {
                $insert = [
                    'pp_id' => $pp_id,
                    'sw_no' => $swno,
                    'day' => $a->Day,
                    'start_time' => $a->StartTime,
                    'end_time' => $a->EndTime,
                ];
                DB::Table('support_worker_available_time')->insert($insert);
            }

            //insert swpaypointlist
            $paypoint = DB::connection('v1')->table('swpaypointlist')->where('SWNo', $s->ProviderNo)->get();
            foreach ($paypoint as $a) {
                $insert = [
                    'pp_id' => $pp_id,
                    'sw_no' => $swno,
                    'pay_point_id' => $a->Point,
                    'start_date' => null,
                    'end_date' => $a->EDate,
                ];
                DB::Table('support_worker_pay_point')->insert($insert);
            }

            //insert swquali
            $quali = DB::connection('v1')->table('swquali')->where('SWNo', $s->ProviderNo)->get();
            foreach ($quali as $a) {
                $insert = [
                    'pp_id' => $pp_id,
                    'sw_no' => $swno,
                    'rank' => $a->Rank,
                    'qualification_id' => null,
                    'qualification_title' => $a->Quali,
                    'qualification_date' => $a->QDate,
                    'qualification_expiring_date' => null,
                    'pay_level' => $a->PayLevel,
                ];
                DB::Table('support_worker_qualification')->insert($insert);
            }

            //insert training
            $training = DB::connection('v1')->table('training')->where('SWNo', $s->ProviderNo)->get();
            foreach ($training as $a) {
                $insert = [
                    'pp_id' => $pp_id,
                    'sw_no' => $swno,
                    'training_id' => $a->TID,
                    'training_name' => $a->TName,
                    'training_date' => $a->TDate,
                ];
                DB::Table('support_worker_training')->insert($insert);
            }

        }
    }

    public function sync_information_customer()
    {
        //customer
        $customer = DB::connection('v1')->table('tblcustomernumbers');
        //$customer->whereIn('CustomerNo', ['3171', '5422']);
        $customer = $customer->get();

        foreach ($customer as $c) {
            $pp = DB::connection('v1')->table('tblpersonnelparticulars')->where('CustomerNo', $c->CustomerNo)->first();
            $cs = DB::connection('v1')->table('customerservice')->where('CustomerNo', $c->CustomerNo)->first();

            $cust_no = $c->CustomerNo;
            //insert pp
            $insert_pp = [
                'salutation' => null,
                'first_name' => $pp->FirstName,
                'middle_name' => $pp->Middle,
                'surname' => $pp->Surname,
                'chinese_name' => $cs->ChinName ?? null,
                'prefer_name' => $cs->PreferedName ?? null,
                'dob' => $pp->DOB,
                'gender' => $pp->Gender,
                'photo' => $pp->Photo,
                'phone' => $pp->Phone,
                'email' => $pp->Email,
                'mobile' => $pp->Mobile,
                'driving_license' => null,
                'driving_license_no' => null,
                'driving_license_expiring_date' => null,
                'has_vehicle' => null,
                'vehicle_no' => null,
                'vehicle_type' => null,
                'vehicle_insurance_chk' => null,
                'vehicle_insurance_expiring_date' => null,
                'vehicle_last_service_date' => null,
                'primary_language' => null,
                'seconday_language' => null,
                'other_language' => null,
                'prefer_language' => $c->LanguagePreferred,

                'medical_care_no' => $pp->MediCareNo,
                'medical_care_status' => $pp->MedStatus,
                'slk_no' => $pp->slk,
                'nationality' => $c->CuturalBackground,
                'understand_english' => $c->UnderstandEng,
                'living_status' => $c->LivingStatus,
                'housing_type' => $c->HousingType,
                'income_type' => $c->Income,
                'religion' => $c->Religion,
                'note_service_type' => null,
                'note_hobby' => null,
                'note' => null,
                'mailing_langauge_code' => $pp->MailingLangCode,
            ];

            $pp_id = DB::Table('personal_particular')->insertGetId($insert_pp);

            //insert customer
            $insert = [
                'pp_id' => $pp_id,
                'customer_no' => $c->CustomerNo,
                'aged_care_user_id' => $c->AgedCareUserID,
                'customer_status' => $c->ServiceStatusCode,
                'mds_no' => $c->MDSNo,
                'note' => null,
                'note_health_condition' => $c->HealthCondition,
                'note_transport' => $c->TransportNote,
            ];
            DB::table('customer')->insert($insert);

            //insert customer dex
            $dex = DB::connection('v1')->table('clientinfo4dex')->where('CustNo', $c->CustomerNo)->first();
            if ($dex != null) {
                $insert = [
                    'pp_id' => $pp_id,
                    'customer_no' => $c->CustomerNo,
                    'json' => json_encode($dex),
                ];
                DB::table('customer_dex')->insert($insert);
            }

            //insert customer mds
            $mds = DB::connection('v1')->table('clientinfo4mds')->where('CustNo', $c->CustomerNo)->first();
            if ($mds != null) {
                $insert = [
                    'pp_id' => $pp_id,
                    'customer_no' => $c->CustomerNo,
                    'json' => json_encode($mds),
                ];
                DB::table('customer_mds')->insert($insert);
            }

            if ($pp->PostatStreetNo == null || $pp->PostatStreetNo == '') {
                $mailing = 1;
            } else {
                //postrak address
                DB::table('personal_particular_address')->insert([
                    'pp_id' => $pp_id,
                    'street_no' => $pp->PostatStreetNo,
                    'street_name' => $pp->PostalStreetName,
                    'suburb' => $pp->PostalSuburb,
                    'state' => $pp->PostalState,
                    'post_code' => $pp->PostalPostCode,
                    //'address_type' =>,
                    'mailing' => 1,
                    'region' => $pp->Region,
                ]);
            }
            if ($pp->No != '' || $pp->No != null) {
                //staying address
                DB::table('personal_particular_address')->insert([
                    'pp_id' => $pp_id,
                    'street_no' => $pp->No,
                    'street_name' => $pp->Street,
                    'suburb' => $pp->Suburb,
                    'state' => $pp->State,
                    'post_code' => $pp->PostCode,
                    //'address_type' => 'Staying',
                    'gps_location' => $pp->LatLng,
                    'mailing' => $mailing ?? 0,
                    'region' => $pp->Region,
                ]);
            }

            //emrgerge contact 1 to relationship
            if ($c->ECFirstName != null || $c->ECFirstName != '') {
                //insert emergency 1
                $em_pp_id = DB::Table('personal_particular')->insertGetId([
                    'prefer_name' => $c->ECPreferName,
                    'first_name' => $c->ECFirstName,
                    'middle_name' => $c->ECMiddle,
                    'surname' => $c->ECSurname,
                    'phone' => $c->ECPhone,
                    'mobile' => $c->ECMobile,
                    'email' => $c->ECEmail,
                ]);
                $em_relationship = DB::connection('v1')->table('relationship')->where('ID', $c->ECRelationship)->first();
                if ($em_relationship != null) {
                    $em_v2_rel = DB::table('setting_relationship')->where('relationship', $em_relationship->Relationship)->first();
                    $em_v2_rel_id = $em_v2_rel->id ?? 0;

                } else {
                    $em_v2_rel_id = 0;
                }
                $this->insert_pp_relationship($pp_id, $em_pp_id, $em_v2_rel_id, 'Emergency Contact');
            }

            //emrgerge contact 2 to relationship
            if ($c->{'2ECFirstName'} != null || $c->{'2ECFirstName'} != '') {
                //insert emergency 2
                $em2_pp_id = DB::Table('personal_particular')->insertGetId([
                    'prefer_name' => $c->{'2ECPreferName'},
                    'first_name' => $c->{'2ECFirstName'},
                    'middle_name' => $c->{'2ECMiddle'},
                    'surname' => $c->{'2ECSurname'},
                    'phone' => $c->{'2ECPhone'},
                    'mobile' => $c->{'2ECMobile'},
                    'email' => $c->{'2ECEmail'},
                ]);

                $em2_relationship = DB::connection('v1')->table('relationship')->where('ID', $c->{'2ECRelationship'})->first();
                if ($em2_relationship != null) {
                    $em2_v2_rel = DB::table('setting_relationship')->where('relationship', $em2_relationship->Relationship)->first();
                    $em2_v2_rel_id = $em2_v2_rel->id ?? 0;
                } else {
                    $em2_v2_rel_id = 0;
                }
                $this->insert_pp_relationship($pp_id, $em2_pp_id, $em2_v2_rel_id, 'Emergency Contact');
            }

            if ($pp->PrimaryCarerNo != '' || $pp->PrimaryCarerNo != null) {
                $pc_pp = DB::table('customer')->where('customer_no', $pp->PrimaryCarerNo)->first();
                if ($pc_pp != null) {
                    $pc_pp_id = $pc_pp->pp_id;
                    //primart carer link relationship
                    $pc_relationship = DB::connection('v1')->table('relationship')->where('ID', $c->Relationship)->first();
                    if ($pc_relationship != null) {
                        $pc_v2_rel = DB::table('setting_relationship')->where('relationship', $pc_relationship->Relationship)->first();
                        $pc_v2_rel_id = $em2_v2_rel->id ?? 0;
                    } else {
                        $pc_v2_rel_id = 0;
                    }
                    $this->insert_pp_relationship($pp_id, $pc_pp_id, $pc_v2_rel_id, 'Service Receiver');
                }
            }

            if ($pp->SRNo != '' || $pp->SRNo != null) {
                $sr_pp = DB::table('customer')->where('customer_no', $pp->SRNo)->first();

                if ($sr_pp != null) {
                    $sr_pp_id = $sr_pp->pp_id;
                    //primart carer link relationship
                    $sr_relationship = DB::connection('v1')->table('relationship')->where('ID', $c->Relationship)->first();
                    if ($sr_relationship != null) {
                        $sr_v2_rel = DB::table('setting_relationship')->where('relationship', $sr_relationship->Relationship)->first();
                        $sr_v2_rel_id = $em2_v2_rel->relate_opposite_id ?? 0;
                    } else {
                        $sr_v2_rel_id = 0;
                    }
                    $this->insert_pp_relationship($sr_pp_id, $pp_id, $sr_v2_rel_id, 'Primary Carer');
                }
            }

            //medical history
            $medical = DB::connection('v1')->table('medicalhistory')->where('Customer no', $c->CustomerNo)->get();
            foreach ($medical as $a) {
                $insert = [
                    'pp_id' => $pp_id,
                    'medical' => $a->Medical,
                ];
                DB::table('personal_particular_medical_history')->insert($insert);
            }

        }
    }

    public function sync_information_volunteer()
    {

        $volunteer = DB::connection('v1')->table('volunteerinfo')->get();
        foreach ($volunteer as $s) {

            $pp = DB::connection('v1')->table('volunteerparticulars')->where('VNo', $s->VNo)->first();
            $vno = $s->VNo;
            //insert pp
            $insert_pp = [
                'salutation' => $pp->Salute,
                'first_name' => $pp->GivenName,
                'middle_name' => null,
                'surname' => $pp->LastName,
                'chinese_name' => $pp->ChinName,
                'prefer_name' => $pp->PreferredName,
                'dob' => $pp->DOB,
                'gender' => null,
                'photo' => $pp->Photo,
                'phone' => $pp->Phone,
                'email' => $pp->Email,
                'mobile' => $pp->Mobile,

                'driving_license' => $s->DriverLic,
                'driving_license_no' => null,
                'driving_license_expiring_date' => null,
                'has_vehicle' => $s->HasVehicle,
                'vehicle_no' => null,
                'vehicle_type' => null,
                'vehicle_insurance_chk' => $s->VehInsurance,
                'vehicle_insurance_expiring_date' => null,
                'vehicle_last_service_date' => null,

                'primary_language' => null,
                'seconday_language' => null,
                'other_language' => $pp->OtherLang,
                'prefer_language' => $pp->PreferredLang,

                'occupation' => $pp->Occupation,
                'residential_status' => $pp->ResidentialSts,

                'medical_care_no' => null,
                'medical_care_status' => null,
                'slk_no' => null,
                'nationality' => $pp->CountryOfBirth,
                'understand_english' => $pp->UnderstandEng,
                'living_status' => null,
                'housing_type' => null,
                'income_type' => null,
                'religion' => $pp->Religion,
                'note_service_type' => $s->Program,
                'note_hobby' => $pp->Hobbies,
                'note' => $pp->Skill . "\n" . $pp->Note,
                'mailing_langauge_code' => null,
            ];

            $pp_id = DB::Table('personal_particular')->insertGetId($insert_pp);

            $insert_sw = [
                'pp_id' => $pp_id,
                'sw_no' => $s->VNo,
                'caseworker_id' => null,
                'supervisor_id' => null,
                'active' => $pp->Active,
                'is_staff' => $pp->IsStaff,
                'employ_date' => $pp->JoinedDate,
            ];
            $sw_id = DB::table('support_worker')->insertGetId($insert_sw);

            //insert support worker type
            DB::Table('support_worker_type')->insert([
                'pp_id' => $pp_id,
                'sw_no' => $s->VNo,
                'type' => 'Volunteer',
                'start_date' => $pp->JoinedDate,
                'end_date' => null,
                'hrs_allocated_per_fortnight' => null,
            ]);

            $available_time = DB::connection('v1')->table('vavatime')->where('VNo', $s->VNo)->get();
            foreach ($available_time as $a) {
                DB::table('support_worker_available_time')
                    ->insert([
                        'pp_id' => $pp_id,
                        'sw_no' => $a->VNo,
                        'day' => $a->Day,
                        'start_time' => $a->StartTime,
                        'end_time' => $a->EndTime,
                    ]);
            }

            /*
        $emer_contact = DB::connection('v1')->table('vemercontact')->where('VNo',$s->VNo)->get();
        foreach($emer_contact as $a){

        }
         */

        }
    }

    public function insert_pp_relationship($pp_id, $relate_pp_id, $relate_id, $group_relation)
    {
        if ($pp_id == $relate_pp_id) {
            return;
        }

        $oppo_relate_id = DB::table('setting_relationship')->where('id', $relate_id)->first()->relate_opposite_id;
        DB::table('personal_particular_relationship')->updateOrInsert(
            [
                'pp_id' => $pp_id,
                'relate_pp_id' => $relate_pp_id,
            ]
            , [
                'pp_id' => $pp_id,
                'relate_pp_id' => $relate_pp_id,
                'relationship_id' => $relate_id,
                'group_relation' => $group_relation,
            ]);

        $rel_group_relationship = '';
        if ($group_relation == 'Service Receiver') {
            $rel_group_relationship = 'Primary Carer';
        } elseif ($group_relation == 'Primary Carer') {
            $rel_group_relationship = 'Service Receiver';
        } else {
            $rel_group_relationship = 'Relate- ' . $group_relation;
        }

        DB::table('personal_particular_relationship')->updateOrInsert(
            [
                'pp_id' => $relate_pp_id,
                'relate_pp_id' => $pp_id,
            ]
            , [
                'pp_id' => $relate_pp_id,
                'relate_pp_id' => $pp_id,
                'relationship_id' => $oppo_relate_id,
                'group_relation' => $rel_group_relationship,
            ]);
    }

    public function sync_services()
    {
        dd('Pending');
        $this->sync_setting_service();
        $from = "2020-01-01";

        //Service Planning
        $careplan = DB::connection('v1')->table('careplan')->get();
        dd($careplan);
        //Service Assignment
        $hhassignment = DB::connection('v1')->table('hhassignment')->where('ServiceDate', '>=', $from)->get();
        dd($hhassignment);
    }

    /*
    FOR SYNC CDC PRICE FROM V1
    And Update Budget Plan Price Info
     */
    public function sync_price()
    {

        $this->iredv1_service_breakdown_barebone();
        $this->sync_setting_hcp_service_price();
        $this->sync_setting_agency_service_price();

        //cdcsubsupp
        DB::table('setting_services_price_plan_group')->truncate();
        DB::table('setting_services_price_plan_group_item')->truncate();

        $v2_price_lists = DB::table('setting_services_price_plan')->get();
        //insert group cdcsubsupp
        foreach ($v2_price_lists as $p) {
            $start_date = $p->start_date;

            $insert_group_supp = [
                'service_id' => $p->service_id,
                'price_plan_id' => $p->id,
                'group_name' => 'CDC Sub Supp',
            ];
            $insert_group_wkly = [
                'service_id' => $p->service_id,
                'price_plan_id' => $p->id,
                'group_name' => 'CDC Weekly Charge',
            ];
            $group_supp_id = DB::table('setting_services_price_plan_group')->insertGetId($insert_group_supp);
            $group_wkly_id = DB::table('setting_services_price_plan_group')->insertGetId($insert_group_wkly);
            $closest_effective_date = DB::connection('v1')->Table('cdcwklycharge')->where('EffectiveDate', '<=', $start_date)->max('EffectiveDate');
            $v1_wkly_charge = DB::connection('v1')->table('cdcwklycharge')->where('EffectiveDate', $closest_effective_date)->get();

            $col_wkly = [
                'InitialAssessmentCost' => ['input_type' => 'fixed', 'title' => 'Initial Assessment Cost'],
                'AdminFeePercent' => ['input_type' => 'percentage', 'title' => 'Admin Fee Percent'],
                'ContinPercent' => ['input_type' => 'percentage', 'title' => 'Contin Percent'],
                'SrvExitFee' => ['input_type' => 'fixed', 'title' => 'Srv Exit Fee'],
                'PackageManagement' => ['input_type' => 'fixed', 'title' => 'Package Management'],
                'CareManagement' => ['input_type' => 'fixed', 'title' => 'Care Management'],
            ];

            //define arr
            $wkly_re = [];
            foreach ($col_wkly as $k => $c) {
                $wkly_re[$k] = [
                    'service_id' => $p->service_id,
                    'price_plan_id' => $p->id,
                    'group_id' => $group_wkly_id,
                    'group_name' => 'CDC Weekly Charge',
                    'title' => $c['title'],
                    'type' => 'expense',
                    'input_type' => $c['input_type'],
                    'default_value' => '',
                    'level1' => '',
                    'level2' => '',
                    'level3' => '',
                    'level4' => '',
                    'reference_group_id' => '',
                ];
            }

            //convert data stucture to v2
            foreach ($v1_wkly_charge as $wc) {
                foreach ($wc as $k => $v) {
                    if (array_key_exists($k, $col_wkly)) {
                        $wkly_re[$k]["level" . $wc->Level] = $v;
                    }
                }
            }

            foreach ($wkly_re as $w) {
                DB::Table('setting_services_price_plan_group_item')->insert($w);
            }

            // CDC Sub Supp
            $v1_sub_supp = DB::connection('v1')->table('cdcsubsupp')->where('EffectiveDate', $closest_effective_date)->get();
            $col_supp = [
                'Basic' => ['input_type' => 'checkbox', 'title' => 'Basic'],
                'Dementia' => ['input_type' => 'checkbox', 'title' => 'Dementia'],
                'Veteran' => ['input_type' => 'checkbox', 'title' => 'Veteran'],
                'Oxygen' => ['input_type' => 'checkbox', 'title' => 'Oxygen'],
                'Bolus' => ['input_type' => 'checkbox', 'title' => 'Bolus'],
                'NBolus' => ['input_type' => 'checkbox', 'title' => 'NBolus'],
                'EACHD' => ['input_type' => 'checkbox', 'title' => 'EACHD'],
            ];
            //define arr
            $supp_re = [];
            foreach ($col_supp as $k => $c) {
                $supp_re[$k] = [
                    'service_id' => $p->service_id,
                    'price_plan_id' => $p->id,
                    'group_id' => $group_supp_id,
                    'group_name' => 'CDC Sub Supp',
                    'title' => $c['title'],
                    'type' => 'income',
                    'input_type' => $c['input_type'],
                    'default_value' => '',
                    'level1' => '',
                    'level2' => '',
                    'level3' => '',
                    'level4' => '',
                    'reference_group_id' => '',
                ];
            }

            //convert data stucture to v2
            foreach ($v1_sub_supp as $ss) {
                foreach ($ss as $k => $v) {
                    if (array_key_exists($k, $col_supp)) {
                        $supp_re[$k]["level" . $ss->Level] = $v;
                    }
                }
            }

            foreach ($supp_re as $w) {
                DB::Table('setting_services_price_plan_group_item')->insert($w);
            }
        }

        //create group/ udpate price for budget plan
        //$budget_plan = DB::table('budget_plan')

        $budget_plans = DB::Table('budget_plan')->get();
        foreach ($budget_plans as $bp) {
            $this->link_budget_plan_to_pricing($bp->id);

            if ($bp->price_plan_id == null || $bp->level == null) {
                continue;
            }
            $level = $bp->level;
            //get plan group item
            $gp_items = DB::Table('setting_services_price_plan_group_item')->where('price_plan_id', $bp->price_plan_id)->get();
            DB::Table('budget_plan_group_item')->where('budget_plan_id', $bp->id)->delete();
            foreach ($gp_items as $i) {

                $value = $i->{'level' . $level};
                $insert = [
                    'budget_plan_id' => $bp->id,
                    'group_item_id' => $i->id,
                    'price_plan_id' => $bp->price_plan_id,
                    'group_id' => $i->group_id,
                    'group_name' => $i->group_name,
                    'title' => $i->title,
                    'type' => $i->type,
                    'input_type' => $i->input_type,
                    'is_checked' => null,
                    'value' => $value,
                    'amount' => null,
                    'reference_group_id' => $i->reference_group_id,
                ];
                DB::Table('budget_plan_group_item')->insert($insert);
            }

        }

        $this->sync_cdc_evergreen();

    }

    //link budget plan to pricing based on effectove
    public function link_budget_plan_to_pricing($budget_plan_id)
    {
        $bp = DB::table('budget_plan')->where('id', $budget_plan_id)->first();
        $ag = DB::table('service_agreement')->where('id', $bp->agreement_id)->first();
        $service_id = $ag->service_id;
        $start_date = $bp->start_date;
        if ($start_date == null) {
            return;
        }

        //get price plan
        $p = DB::table('setting_services_price_plan')->where('service_id', $service_id)->where('start_date', '<=', $start_date)->orderBy('start_date', 'DESC')->first();
        if ($p != null) {
            DB::table('budget_plan')->where('id', $budget_plan_id)->update(['price_plan_id' => $p->id]);
        }
    }

    public function sync_cdc_evergreen()
    {
        //sync evergreen
        //truncate v2 evergreen
        DB::table('setting_servic_price_plan_cdc_evergreen_price')->truncate();
        $v2_price_lists = DB::table('setting_services_price_plan')->get();
        //sync cdc_evergreen pricing
        foreach ($v2_price_lists as $p) {
            $start_date = $p->start_date;

            $v1_evergreen = DB::connection('v1')->table('cdc_evergreen_price')->where('EffectiveDate', '<=', $start_date)->orderBy('EffectiveDate', 'DESC')->first();
            if ($v1_evergreen == null) {
                continue;
            }

            $insert = [
                'service_id' => $p->service_id,
                'price_plan_id' => $p->id,
                'AMFee' => $v1_evergreen->AMFee,
                'PMFee' => $v1_evergreen->PMFee,
                'CombinedFee' => $v1_evergreen->CombinedFee,
                'AMFee' => $v1_evergreen->AMFee,
            ];
            DB::Table('setting_servic_price_plan_cdc_evergreen_price')->insert($insert);
        }

        //sync pricing to budget plan
        $budget_plan = DB::table('budget_plan_cdc_evergreen_price')->get();
        foreach ($budget_plan as $bp) {
            if ($bp->price_plan_id == null) {
                continue;
            }
            $evergreen_price_plan = DB::table('setting_servic_price_plan_cdc_evergreen_price')
                ->where('price_plan_id', $bp->price_plan_id)
                ->first();
            if ($evergreen_price_plan == null) {
                continue;
            }

            DB::table('budget_plan_cdc_evergreen_price')
                ->where('id', $bp->ID)
                ->update([
                    'AMFee' => $evergreen_price_plan->AMFee,
                    'PMFee' => $evergreen_price_plan->PMFee,
                    'CombinedFee' => $evergreen_price_plan->CombinedFee,
                ]);
        }
        //END OF sync cdc_evergreen pricing

    }

    public function sync_setting_hcp_service_price()
    {
        $group = DB::connection('v1')->table('servicerate_hcp')->groupBy('EffectiveDate')->get();

        DB::table('setting_services_price_plan')->where('service_id', 2)->delete();
        DB::table('setting_services_price_plan_breakdown_items')->where('service_id', 2)->delete();
        foreach ($group as $g) {
            $g_insert = [
                'service_id' => 2,
                'title' => 'Plan As at ' . $g->EffectiveDate,
                'start_date' => $g->EffectiveDate,
            ];
            /* Create Plan Title */
            $price_plan_id = DB::table('setting_services_price_plan')->insertGetId($g_insert);

            /* Get Plan Ite, */
            $data = DB::connection('v1')->table('servicerate_hcp')->where('EffectiveDate', $g->EffectiveDate)->get();
            $lists_code = DB::table('setting_services_breakdown')->where('service_id', 2)->pluck('code', 'code')->toArray();
            $rate_type_convert = [
                'WkDay' => 'wk',
                'Sat' => 'sat',
                'Sun' => 'sun',
                'Pholiday' => 'pb',
            ];
            $converted_data = [];
            foreach ($data as $d) {
                foreach ($lists_code as $c) {
                    $c = TRIM($c);
                    $converted_data[$c][$rate_type_convert[$d->RateType]] = $d->$c;
                    $converted_data[$c][$rate_type_convert[$d->RateType] . '_ot'] = $d->{$c . '_OT'};
                }
            }
            foreach ($converted_data as $code => $price) {
                $b = DB::table('setting_services_breakdown')->where('service_id', 2)->where('code', $code)->first();
                $price_with_half = [];
                foreach ($price as $p_k => $p) {
                    $price_with_half[$p_k] = $p;
                    $price_with_half[$p_k . '_half'] = $p / 2;
                }

                $insert = [
                    'service_id' => 2,
                    'price_plan_id' => $price_plan_id,
                    'breakdown_id' => $b->id,
                    'breakdown_name' => $b->name,
                    'breakdown_code' => $b->code,
                    'breakdown_uom' => $b->uom,
                ] + $price_with_half;
                DB::table('setting_services_price_plan_breakdown_items')->insert($insert);
            }

        }

    } //END OF FUNCTION SYNC HCP PRICE FROM IRED V1

    public function sync_setting_agency_service_price()
    {
        $service_id = 4;
        $group = DB::connection('v1')->table('servicerate_agency2')->groupBy('EffectiveDate')->get();
        $maintenance = DB::connection('v1')->table('service_price_maintenance')->get();

        DB::table('setting_services_price_plan')->where('service_id', $service_id)->delete();
        DB::table('setting_services_price_plan_breakdown_items')->where('service_id', $service_id)->delete();
        foreach ($maintenance as $g) {
            $g_insert = [
                'service_id' => $service_id,
                'title' => $g->PriceName,
                'start_date' => '',
                'normal_start_time' => $g->NormalStart,
                'normal_end_time' => $g->NormalEnd,
            ];
            /* Create Plan Title */
            $price_plan_id = DB::table('setting_services_price_plan')->insertGetId($g_insert);

            /* Get Plan Ite, */
            $data = DB::connection('v1')->table('servicerate_agency2')->where('PriceMaintenanceID', $g->ID)->get();
            $lists_code = DB::table('setting_services_breakdown')->where('service_id', $service_id)->pluck('code', 'code')->toArray();
            $rate_type_convert = [
                'WkDay' => 'wk',
                'Sat' => 'sat',
                'Sun' => 'sun',
                'PHoliday' => 'pb',
            ];
            $converted_data = [];

            foreach ($data as $d) {
                foreach ($lists_code as $c) {
                    $c = TRIM($c);

                    $converted_data[$c][$rate_type_convert[$d->RateType]] = $d->$c;
                    $converted_data[$c][$rate_type_convert[$d->RateType] . '_half'] = $d->{$c . '_Half'};
                    $converted_data[$c][$rate_type_convert[$d->RateType] . '_ot'] = $d->{$c . '_OT'};
                    $converted_data[$c][$rate_type_convert[$d->RateType] . '_ot_half'] = $d->{$c . '_HalfOT'};
                }
            }

            foreach ($converted_data as $code => $price) {
                $b = DB::table('setting_services_breakdown')->where('service_id', $service_id)->where('code', $code)->first();

                $insert = [
                    'service_id' => $service_id,
                    'price_plan_id' => $price_plan_id,
                    'breakdown_id' => $b->id,
                    'breakdown_name' => $b->name,
                    'breakdown_code' => $b->code,
                    'breakdown_uom' => $b->uom,
                ] + $price;
                DB::table('setting_services_price_plan_breakdown_items')->insert($insert);
            }

        }
    } //END OF FUNCTION SYNC AGENCY PRICE FROM IRED V1

    /*
    only applicable for service id 1 ,2 ,4
     */
    public function iredv1_service_breakdown_barebone()
    {
        $hcp = [
            [
                'code' => 'HH',
                'name' => 'Cleaning and Household Task',
                'uom' => 'hours',
            ],
            [
                'code' => 'SSR',
                'name' => 'Social Support',
                'uom' => 'hours',
            ],
            [
                'code' => 'PC',
                'name' => 'Personal Care',
                'uom' => 'hours',
            ],
            [
                'code' => 'T',
                'name' => 'Transport Mileage',
                'uom' => 'mileage',
            ],
            [
                'code' => 'NR',
                'name' => 'Nursing',
                'uom' => 'hours',
            ],
            [
                'code' => 'HM',
                'name' => 'Garden Maintenance',
                'uom' => 'amount',
            ],
            [
                'code' => 'AH',
                'name' => 'Allied Health',
                'uom' => 'amount',
            ],
            [
                'code' => 'Med',
                'name' => 'Medication',
                'uom' => 'hours',
            ],
            [
                'code' => 'PR',
                'name' => 'Home Respite',
                'uom' => 'hours',
            ],
            [
                'code' => 'MP',
                'name' => 'Meals Preparation',
                'uom' => 'hours',
            ],
            [
                'code' => 'DA ',
                'name' => 'Domestic Assitance ',
                'uom' => 'hours',
            ],
        ];

        $hh = [
            [
                'code' => 'PC',
                'name' => 'Personal Care',
                'uom' => 'hours',
            ],
            [
                'code' => 'DA',
                'name' => 'Domestice Assistance',
                'uom' => 'hours',
            ],
            [
                'code' => 'RC',
                'name' => 'Respite Care',
                'uom' => 'hours',
            ],
            [
                'code' => 'Soc',
                'name' => 'Social Support',
                'uom' => 'hours',
            ],
            [
                'code' => 'TH',
                'name' => 'Trip Hours',
                'uom' => 'hours',
            ],
            [
                'code' => 'TD',
                'name' => 'Trip Duty',
                'uom' => 'session',
            ],
        ];

        DB::table('setting_services_breakdown')->where('service_id', 1)->delete();
        DB::table('setting_services_breakdown')->where('service_id', 2)->delete();
        DB::table('setting_services_breakdown')->where('service_id', 4)->delete();
        foreach ($hcp as $d) {
            $d['service_id'] = 2;
            DB::table('setting_services_breakdown')->insert($d);
        }
        foreach ($hcp as $d) {
            $d['service_id'] = 4;
            DB::table('setting_services_breakdown')->insert($d);
        }
        foreach ($hh as $d) {
            $d['service_id'] = 1;
            DB::table('setting_services_breakdown')->insert($d);
        }

    }
}
