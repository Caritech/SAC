<?php

namespace Modules\VLife\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use Modules\VLife\Entities\Contacts;
//insurance
use Modules\VLife\Entities\Insurance;
use Modules\VLife\Entities\Insurance\Coverage as InsuranceCoverage;
use Modules\VLife\Entities\Insurance\ProjectedBenefit as InsuranceProjectedBenefit;
use Modules\VLife\Classes\Lists;
use Modules\VLife\Classes\VueTable;

class SummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_recommendation(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = Insurance::from('vlife_insurance AS i');
        $data->where('contact_id', $contact_id);
        $data->where('insurance_type', 'recommendation');
        $data->leftJoin('vlife_insurance_coverage AS vic', 'vic.insurance_id', '=', 'i.id');
        $data->selectRaw('
            i.*,
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
        $data = $data->get();
        return $data;
    }

    public function get_income_by_type(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = DB::table('vlife_cashflow AS vc');
        $data->selectRaw('
            type,
            SUM( IF( frequency="Monthly", amount*12, amount)) AS amount
        ');
        $data->groupBy('type');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data->where('status', 1);
        $data = $data->get();

        $arr = [
            'Gross Income' => [
                'color' => '#2962FF',
                'amount' => 0,
            ],
            'Bonus' => [
                'color' => '#FF4081',
                'amount' => 0,
            ],
            'Dividend' => [
                'color' => '#64DD17',
                'amount' => 0,
            ],
            'Rental' => [
                'color' => '#FDD835',
                'amount' => 0,
            ],
        ];

        foreach ($data as $d) {
            $type = $d->type;
            $arr[$type]['amount'] = $d->amount;
        }

        return $arr;
    }

    public function get_assets_investment_by_type(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = DB::table('vlife_asset_investment AS vai');
        $data->selectRaw('
            type,
            current_value AS amount
        ');
        $data->groupBy('type');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data->where('status', 1);
        $data = $data->get();

        $arr = [
            'Property' => [
                'color' => '#FF4081',
                'amount' => 0,
            ],
            'EPF' => [
                'color' => '#F57F17',
                'amount' => 0,
            ],
            'Unit Trust' => [
                'color' => '#FFD54F',
                'amount' => 0,
            ],
            'Saving' => [
                'color' => '#00E676',
                'amount' => 0,
            ],
            'Insurance' => [
                'color' => '#2979FF',
                'amount' => 0,
            ],
            'Private Equity' => [
                'color' => '#D500F9',
                'amount' => 0,
            ],
        ];

        foreach ($data as $d) {
            $type = $d->type;
            $arr[$type]['amount'] = $d->amount;
        }

        return $arr;
    }

    public function get_insurance_policy_summary(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = Contacts::find($contact_id);
        $age = $contact->age;

        $data = DB::Table('vlife_insurance AS vi');
        $data->selectRaw('vic.*');
        $data->where('contact_id', $contact_id);
        $data->leftJoin('vlife_insurance_coverage AS vic', 'vi.id', '=', 'vic.insurance_id');
        $data = $data->get();

        //with age
        $result = [
            'Accidental' => [
                'color' => '#5D4037',
                'title' => 'Accidental',
                'items' => [],
            ],
            'Medical' => [
                'color' => '#2979FF',
                'title' => 'Medical',
                'items' => [],
            ],
            'Death' => [
                'color' => '#FF4081',
                'title' => 'Death',
                'items' => [],
            ],
            'TPD' => [
                'color' => '#006064',
                'title' => 'TPD',
                'items' => [],
            ],
            'Critical Illesses' => [
                'color' => '#00E676',
                'title' => 'CI',
                'items' => [],
            ],
            'Early CI' => [
                'color' => '#00E5FF',
                'title' => 'Early CI',
                'items' => [],
            ],
            'Others' => [
                'color' => '#F57F17',
                'title' => 'Others',
                'items' => [],
            ],

        ];

        $count_age = $age;
        while ($count_age < 100) {
            foreach ($data as $d) {
                $age_from = $d->coverage_age_from;
                $age_to = $d->coverage_age_to;
                $type = $d->coverage_type;

                foreach ($result as $key => $v) {
                    if (!isset($result[$key]['items'][$count_age])) {
                        $result[$key]['items'][$count_age] = [
                            'amount' => 0
                        ];
                    }

                    if ($key == $type && $count_age >= $age_from && $count_age <= $age_to) {
                        $result[$key]['items'][$count_age]['amount'] += $d->sum_assured;
                    }
                }
            }
            $count_age += 1;
        }

        return $result;
    }

    public function get_insurance_policy_premium(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = Contacts::find($contact_id);
        $age = $contact->age;

        $data = DB::Table('vlife_insurance AS vi');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data = $data->get();

        //with age
        $result = [
            'Premium' => [
                'color' => '#FF4081',
                'title' => 'Premium',
                'items' => [],
            ],
        ];

        $count_age = $age;
        while ($count_age < 100) {
            foreach ($data as $d) {
                $age_from = $d->premium_start_age;
                $age_to = $d->premium_maturity_age;
                $type = 'Premium';

                foreach ($result as $key => $v) {
                    if (!isset($result[$key]['items'][$count_age])) {
                        $result[$key]['items'][$count_age] = [
                            'amount' => 0
                        ];
                    }

                    if ($key == $type && $count_age >= $age_from && $count_age <= $age_to) {
                        $result[$key]['items'][$count_age]['amount'] += $d->premium_amount;
                    }
                }
            }
            $count_age += 1;
        }

        return $result;
    }
}
