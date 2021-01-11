<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use mpd\mpdf;
use App\Models\Contacts;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function print_summary_report($id)
    {
        //GET Needs Calcualtor Preference [vlife_nc_preference] 
        //check whether follow Benchmark
        $nc_preference = DB::Table('vlife_nc_preference')->where('contact_id', $id)->first();

        //MEDICAL

        $medical = DB::Table('vlife_medical')
            ->SelectRaw('
                    SUM(total_amount) AS total_amount,
                    GROUP_CONCAT(description) AS description
                ')
            ->where('contact_id', $id)
            ->where('type', 'personal_medical')
            ->where('total_amount', '>', '0')
            ->first();
        $personal_medical['want'] = $medical->total_amount;
        $personal_medical['description'] = $medical->description;


        //Critical Illness

        $ci = DB::Table('vlife_critical_illness')
            ->SelectRaw('
                    SUM(total_amount) AS total_amount,
                    GROUP_CONCAT(description) AS description
                ')
            ->where('contact_id', $id)
            //->where('type', 'income_replacement')
            ->where('total_amount', '>', '0')
            ->first();
        $income_replacement['want'] = $ci->total_amount;
        $income_replacement['description'] = $ci->description;


        //Death TPD

        $death_tpd = DB::Table('vlife_death_tpd')
            ->SelectRaw('
                    type,
                    SUM(total_amount) AS total_amount,
                    GROUP_CONCAT(description) AS description
                ')
            ->where('contact_id', $id)
            ->where('total_amount', '>', '0')
            ->groupBy('type')
            ->get();

        $order_death = [];

        foreach ($death_tpd as $d) {
            $order_death[$d->type] = [
                'want' => $d->total_amount,
                'description' => $d->description
            ];
        }

        $data_want = [];
        //personal_medical
        //income_replacement
        //order_death
        $data_want['personal_medical'] = $personal_medical;
        $data_want['income_replacement'] = $income_replacement;
        $data_want = array_merge($data_want, $order_death);

        //data have
        $data_have = [
            'medical' => 0,
            'critical_illness' => 0, //Critical Illness
            'death_tpd' => 0
        ];

        $medical_insurance = DB::table('vlife_insurance')
            ->selectRaw('
                insurer,
                policy_no,
                medical_benefit_room_board_rate,
                medical_benefit_annual_limit,
                medical_benefit_lifetime_limit,
                medical_benefit_co_insurance,
                medical_benefit_maturity_age,
                medical_benefit_remarks
            ')
            ->where('incl', 1)
            ->where('insurance_type', 'existing')
            ->where('chk_medical_benefit', 1)
            ->where('contact_id', $id)
            ->get();

        foreach ($medical_insurance as $d) {
            $data_have['medical'] += $d->medical_benefit_lifetime_limit;
        }

        $group_insurance = DB::table('vlife_insurance AS i');
        $group_insurance->where('contact_id', $id);
        $group_insurance->where('incl', '1');
        $group_insurance->leftJoin('vlife_insurance_coverage AS vic', 'vic.insurance_id', '=', 'i.id');
        $group_insurance->selectRaw('
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Death","TPD"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_death_tpd,
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Critical Illesses"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_critical_illness,
            0 AS sum_accidental_death_tpd
        ');
        $group_insurance = $group_insurance->first();

        $data_have['critical_illness'] = $group_insurance->sum_critical_illness;
        $data_have['death_tpd'] = $group_insurance->sum_death_tpd;

        //DEATH & TPD need to add Saving, EPF, Unit Trust, Private Qquit
        $assests_investment = DB::table('vlife_asset_investment')->where('contact_id', $id)->where('incl', 1)->sum('current_value');
        $data_have['death_tpd'] += $assests_investment;

        $contact = DB::table('vlife_contacts')->where('id', $id)->first();

        $last_review_date = $contact->last_review_date;
        $special_remark = $contact->special_remark;
        $next_review_date = '';

        if ($last_review_date != null) {
            $next_review_date = date('Y-m-d', strtotime($last_review_date . ' + 3 year'));
        }

        $pdf = new \Mpdf\Mpdf();
        //return view('reports/my_contact/life_assurance_needs_summary_report');
        $html = view('reports/my_contact/life_assurance_needs_summary_report', [
            'want' => $data_want,
            'have' => $data_have,
            'medical_insurance' => $medical_insurance,
            'next_review_date' => $next_review_date,
            'special_remark' => $special_remark
        ])->render();


        $pdf->SetHTMLHeader('
            <div style="float: left; width: 80%;font-size:15px">Name: ' . $contact->name . '</div>
        ');
        $pdf->SetHTMLFooter('<div color="blue" style="float: left; width: 85%">{DATE l, F d, Y} </div> <div>Page {PAGENO} of {nb}</div>');
        //$stylesheet = file_get_contents(public_path('css/material_color.css'));
        //$pdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        //$html = 'asdsad';
        $pdf->WriteHTML($html, 0);
        $pdf->Output();
        //$pdf->Output('Insurance Summary.pdf');
        exit;
    }
}
